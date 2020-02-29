<?php


namespace App\MySQL\Interfaces;


interface IObjectDataManager
{
    /**
     * IObjectDataManager constructor.
     * @param IConnection $connection
     * @param IArrayDataManager $array_data_manager
     */
    public function __construct(IConnection $connection, IArrayDataManager $array_data_manager);

    /**
     * @param string $query
     * @param string $class_name
     * @return ITableRow|null
     */
    public function fetchRow(string $query, string $class_name);

    /**
     * @param string $query
     * @param string $class_name
     * @return ITableRow[]
     */
    public function fetchAll(string $query, string $class_name): array;

    /**
     * @param string $query
     * @param string $hash_key
     * @param string $class_name
     * @return ITableRow[]
     */
    public function fetchAllHash(string $query, string $hash_key, string $class_name): array;

    /**
     * @param ITableRow $row
     * @return ITableRow
     */
    public function save(ITableRow $row): ITableRow;

    /**
     * @param ITableRow $row
     * @return int
     */
    public function delete(ITableRow $row): int;

    /**
     * @param string $value
     * @return string
     */
    public function escape(string $value): string;

    /**
     * @return IArrayDataManager
     */
    public function getArrayDataManager(): IArrayDataManager;

}