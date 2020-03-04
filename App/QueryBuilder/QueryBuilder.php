<?php


namespace App\QueryBuilder;


use App\QueryBuilder\Interfaces\IQueryBuilder;

class QueryBuilder implements IQueryBuilder
{

    /**
     * @var array
     */
    private $query = [];

    /**
     * @param string $columns
     * @return IQueryBuilder
     */
    public function select(string $columns = '*'): IQueryBuilder
    {
        $this->reset();

        $this->query['SELECT'] = $columns;

        return $this;
    }

    /**
     * @param string $table_name
     * @return IQueryBuilder
     */
    public function from(string $table_name): IQueryBuilder
    {
        $this->query['FROM'] = $table_name;

        return $this;
    }

    /**
     * @param string $column
     * @param string $value
     * @param string $condition
     * @return IQueryBuilder
     */
    public function where(string $column, string $value, string $condition = '='): IQueryBuilder
    {
        $this->query['WHERE'][] = "{$column} {$condition} '{$value}'";

        return $this;
    }

    /**
     * @param string $column
     * @param string $param
     * @return IQueryBuilder
     */
    public function orderBy(string $column, string $param = 'ASC'): IQueryBuilder
    {
        $this->query['ORDER BY'] = "{$column} $param ";

        return $this;
    }

    /**
     * @return string
     */
    public function getQuery(): string
    {
        $query = '';

        foreach ($this->query as $key => $value) {
            if ($key == 'WHERE') {
                $query .= $key . ' ' . implode(' AND ', $value);
                continue;
            }

            $query .= $key . ' ' . $value . ' ';
        }

        return $query;
    }

    private function reset()
    {
        $this->query = [];
    }
}