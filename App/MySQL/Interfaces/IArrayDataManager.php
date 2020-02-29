<?php


namespace App\MySQL\Interfaces;


interface IArrayDataManager
{
    /**
     * IArrayDataManager constructor.
     * @param IConnection $connection
     */
    public function __construct(IConnection $connection);

    /**
     * @param string $query
     * @return array
     */
    public function fetchRow(string $query): array;

    /**
     * @param string $query
     * @return array
     */
    public function fetchAll(string $query): array;

    /**
     * @param string $query
     * @param string $hash_key
     * @return array
     */
    public function fetchAllHash(string $query, string $hash_key): array;

    /**
     * @param string $table_name
     * @param array $value
     * @return int
     */
    public function insert(string $table_name, array $value): int;

    /**
     * @param string $table_name
     * @param array $value
     * @param array $where
     * @return int
     */
    public function update(string $table_name, array $value, array $where = []): int;

    /**
     * @param string $table_name
     * @param array $where
     * @return int
     */
    public function delete(string $table_name, array $where = []): int;
}