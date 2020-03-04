<?php


namespace App\MySQL;


use App\MySQL\Exceptions\GivenClassNotImplementerITableRowException;
use App\MySQL\Exceptions\QueryException;
use App\MySQL\Interfaces\IArrayDataManager;
use App\MySQL\Interfaces\IConnection;
use App\MySQL\Interfaces\IObjectDataManager;
use App\MySQL\Interfaces\ITableRow;
use mysqli;
use mysqli_result;

class ObjectDataManager implements IObjectDataManager
{

    /**
     * @var IConnection
     */
    private $connection;

    /**
     * @var IArrayDataManager
     */
    private $array_data_manager;

    /**
     * @inheritDoc
     */
    public function __construct(IConnection $connection, IArrayDataManager $array_data_manager)
    {
        $this->connection = $connection;
        $this->array_data_manager = $array_data_manager;
    }

    /**
     * @param string $query
     * @param string $class_name
     * @return ITableRow|null
     * @throws GivenClassNotImplementerITableRowException
     * @throws QueryException
     */
    public function fetchRow(string $query, string $class_name)
    {
        $this->isITableRowClass($class_name);

        $result = $this->query($query);

        /**
         * @var ITableRow $row
         */
        $row = mysqli_fetch_object($result, $class_name);

        return $row;
    }

    /**
     * @param string $query
     * @param string $class_name
     * @return array
     * @throws GivenClassNotImplementerITableRowException
     * @throws QueryException
     */
    public function fetchAll(string $query, string $class_name): array
    {
        $this->isITableRowClass($class_name);

        $result = $this->query($query);

        $data = [];

        while ($row = mysqli_fetch_object($result, $class_name)) {
            $data[] = $row;
        }

        return $data;
    }

    /**
     * @param string $query
     * @param string $hash_key
     * @param string $class_name
     * @return array
     * @throws GivenClassNotImplementerITableRowException
     * @throws QueryException
     */
    public function fetchAllHash(string $query, string $hash_key, string $class_name): array
    {
        $this->isITableRowClass($class_name);

        $result = $this->query($query);

        $data = [];
        while ($row = mysqli_fetch_object($result, $class_name)) {
            /**
             * @var ITableRow $row
             */
            $key = $row->getColumnValue($hash_key);

            if (is_null($key)) {
                continue;
            }

            $data[$key] = $row;
        }

        return $data;
    }

    /**
     * @param ITableRow $row
     * @return ITableRow
     * @throws GivenClassNotImplementerITableRowException
     * @throws QueryException
     */
    public function save(ITableRow $row): ITableRow
    {
        if ($row->getPrimaryKeyValue() > 0) {
            return $this->update($row);
        }

        return $this->insert($row);
    }

    /**
     * @param ITableRow $row
     * @return int
     */
    public function delete(ITableRow $row): int
    {
        $id = $row->getPrimaryKeyValue();
        $primary_key = $row->getPrimaryKey();

        return $this->getArrayDataManager()->delete($row->getTableName(),[
           $primary_key => $id
        ]);
    }

    /**
     * @param string $value
     * @return string
     */
    public function escape(string $value): string
    {
        return mysqli_real_escape_string($this->getConnect(), $value);
    }

    /**
     * @return IArrayDataManager
     */
    public function getArrayDataManager(): IArrayDataManager
    {
        return $this->array_data_manager;
    }

    /**
     * @param ITableRow $row
     * @return ITableRow
     * @throws GivenClassNotImplementerITableRowException
     * @throws QueryException
     */
    private function insert(ITableRow $row): ITableRow
    {
        $table_name = $row->getTableName();
        $data = $row->getColumnsForInsert();

        $id = $this->getArrayDataManager()->insert($table_name, $data);
        $primary_key = $row->getPrimaryKey();

        $query = "SELECT * FROM $table_name WHERE $primary_key = $id";

        return $this->fetchRow($query, get_class($row));
    }

    /**
     * @param ITableRow $row
     * @return ITableRow
     * @throws GivenClassNotImplementerITableRowException
     * @throws QueryException
     */
    private function update(ITableRow $row): ITableRow
    {
        $data = $row->getColumnsForUpdate();

        $table_name = $row->getTableName();
        $id = $row->getPrimaryKeyValue();
        $primary_key = $row->getPrimaryKey();

        $this->getArrayDataManager()->update($table_name, $data, [
           $primary_key => $id
        ]);

        $query = "SELECT * FROM $table_name WHERE $primary_key = $id";

        return $this->fetchRow($query, get_class($row));
    }

    /**
     * @param string $query
     * @return bool|mysqli_result
     * @throws QueryException
     */
    private function query(string $query)
    {
        $result = mysqli_query($this->getConnect(), $query);
        $this->checkErrors();

        return $result;
    }

    /**
     * @return IConnection
     */
    private function getConnection(): IConnection
    {
        return $this->connection;
    }

    /**
     * @return mysqli
     */
    private function getConnect()
    {
        return $this->getConnection()->getConnect();
    }

    /**
     * @throws QueryException
     */
    private function checkErrors() {
        $mysqli_errno = mysqli_errno($this->getConnect());

        if (!$mysqli_errno) {
            return;
        }

        $mysqli_error = mysqli_error($this->getConnect());

        $message = "Mysql query error: ($mysqli_errno) $mysqli_error";

        throw new QueryException($message);
    }

    /**
     * @param string $class_name
     * @throws GivenClassNotImplementerITableRowException
     */
    private function isITableRowClass(string $class_name) {
        $is_class_exists = class_exists($class_name);
        $class_implements = class_implements($class_name);
        $is_class_implements = in_array(ITableRow::class, $class_implements);

        if ($is_class_exists && $is_class_implements) {
            return;
        }

        $message = "$class_name not implemented ITableRow";
        throw new GivenClassNotImplementerITableRowException($message);
    }
}