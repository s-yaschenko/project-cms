<?php


namespace App\MySQL;


use App\MySQL\Exceptions\QueryException;
use App\MySQL\Interfaces\IArrayDataManager;
use App\MySQL\Interfaces\IConnection;
use mysqli_result;

class ArrayDataManager implements IArrayDataManager
{

    /**
     * @var IConnection
     */
    private $connection;

    /**
     * ArrayDataManager constructor.
     * @param IConnection $connection
     */
    public function __construct(IConnection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @param string $query
     * @return array
     *
     * @throws QueryException
     */
    public function fetchRow(string $query): array
    {
        $result = $this->query($query);

        return $this->fetchArray($result, MYSQLI_ASSOC);
    }

    /**
     * @param string $query
     * @return array
     *
     * @throws QueryException
     */
    public function fetchAll(string $query): array
    {
        $result = $this->query($query);

        $data = [];
        while ($row = $this->fetchArray($result, MYSQLI_ASSOC)) {
            $data[] = $row;
        }

        return $data;
    }

    /**
     * @param string $query
     * @param string $hash_key
     * @return array
     *
     * @throws QueryException
     */
    public function fetchAllHash(string $query, string $hash_key): array
    {
        $result = $this->query($query);

        $data = [];
        while ($row = $this->fetchArray($result, MYSQLI_ASSOC)) {
            $key = $row[$hash_key] ?? null;

            if (is_null($key)) {
                continue;
            }

            $data[] = $row;
        }

        return $data;
    }

    /**
     * @param string $table_name
     * @param array $value
     * @return int
     *
     * @throws QueryException
     */
    public function insert(string $table_name, array $value): int
    {
        $table_name = $this->escape($table_name);

        $columns = array_keys($value);
        $columns = $this->escapeArrayData($columns);
        $columns = implode(',', $columns);

        $value = $this->escapeArrayData($value);

        $value = '\'' . implode('\',\'', $value) . '\'';

        $query = "INSERT INTO $table_name($columns) VALUES ($value)";

        $this->query($query);

        return $this->insertId();
    }

    /**
     * @param string $table_name
     * @param array $value
     * @param array $where
     * @return int
     *
     * @throws QueryException
     */
    public function update(string $table_name, array $value, array $where = []): int
    {
        $table_name = $this->escape($table_name);

        $set_data = $this->escapeArrayData($value,2);
        $set_data = implode(', ', $set_data);

        $where_data = $this->escapeArrayData($where,2);

        $query = "UPDATE $table_name SET $set_data";

        if (!empty($where_data)) {
            $where_data = implode(' AND ', $where_data);
            $query .= ' WHERE ' . $where_data;
        }

        $this->query($query);

        return $this->affectedRows();
    }

    /**
     * @param string $table_name
     * @param array $where
     * @return int
     *
     * @throws QueryException
     */
    public function delete(string $table_name, array $where = []): int
    {
        $table_name = $this->escape($table_name);

        $where_data = $this->escapeArrayData($where, 2);

        $query = "DELETE FROM $table_name";

        if (!empty($where_data)) {
            $where_data = implode(' AND ', $where_data);
            $query .= ' WHERE ' . $where_data;
        }

        $this->query($query);

        return $this->affectedRows();
    }

    /**
     * @param string $query
     * @return bool|mysqli_result
     *
     * @throws QueryException
     */
    private function query(string $query)
    {
        $connect = $this->getConnect();
        $this->checkErrors();

        return mysqli_query($connect, $query);
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
     * @param string $value
     * @return string
     */
    private function escape(string $value): string
    {
        $connect = $this->getConnect();

        return mysqli_real_escape_string($connect, $value);
    }

    /**
     * @param array $value
     * @param int $filter
     * @return array
     */
    private function escapeArrayData(array $value, int $filter = 1): array
    {
        $data = [];

        switch ($filter) {
            case 1:
                $data = array_map(function ($item) {
                    return $this->escape($item);
                }, $value);
                break;
            case 2:
                foreach ($value as $key => $param_value) {
                    $data[] = $this->escape($key) . ' = \'' . $this->escape($param_value) . '\'';
                }
                break;
        }

        return $data;
    }

    /**
     * @return int
     */
    private function affectedRows()
    {
        return mysqli_affected_rows($this->getConnect());
    }

    /**
     * @return int
     */
    private function insertId()
    {
        return mysqli_insert_id($this->getConnect());
    }

    /**
     * @param mysqli_result $result
     * @param int $result_type
     *
     * @return array|null
     */
    private function fetchArray(mysqli_result $result, int $result_type = MYSQLI_BOTH)
    {
        return mysqli_fetch_array($result, $result_type);
    }

    /**
     * @return IConnection
     */
    private function getConnection(): IConnection
    {
        return $this->connection;
    }

    /**
     * @return mixed
     */
    private function getConnect()
    {
        return $this->getConnection()->getConnect();
    }
}