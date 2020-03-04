<?php


namespace App\QueryBuilder\Interfaces;


interface IQueryBuilder
{
    /**
     * @param string $columns
     * @return IQueryBuilder
     */
    public function select(string $columns = '*'): IQueryBuilder;

    /**
     * @param string $table_name
     * @return IQueryBuilder
     */
    public function from(string $table_name): IQueryBuilder;

    /**
     * @param string $column
     * @param string $value
     * @param string $condition
     * @return IQueryBuilder
     */
    public function where(string $column, string $value, string $condition = '='): IQueryBuilder;

    /**
     * @param string $column
     * @param string $param
     * @return IQueryBuilder
     */
    public function orderBy(string $column, string $param = 'ASC'): IQueryBuilder;

    /**
     * @return string
     */
    public function getQuery():string;

}