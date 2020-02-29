<?php


namespace App\Model;


use App\Model\Interfaces\IEntity;
use ReflectionObject;
use ReflectionProperty;

class AbstractEntity implements IEntity
{

    /**
     * @var string
     */
    protected $table_name;

    /**
     * @var string
     */
    protected $primary_key = 'id';

    /**
     * @var array
     */
    protected $table_fields;

    /**
     * @var array
     */
    protected $immutable_table_fields;

    /**
     * AbstractEntity constructor.
     */
    public function __construct()
    {
        $this->table_fields = $this->getDbColumns();
        $this->immutable_table_fields = $this->getImmutableDbColumns();
    }

    public function getTableName(): string
    {
        return $this->table_name;
    }

    public function getPrimaryKey(): string
    {
        return $this->primary_key;
    }

    public function getPrimaryKeyValue(): ?string
    {
        return $this->{$this->getPrimaryKey()};
    }

    public function getColumnValue(string $key): ?string
    {
        return $this->{$key};
    }

    public function getColumnsForUpdate(): array
    {
        $columns = array_diff_assoc(
            $this->table_fields,
            $this->immutable_table_fields
        );

        return $this->getColumnsValues($columns);
    }

    public function getColumnsForInsert(): array
    {
        return $this->getColumnsValues($this->table_fields);
    }

    /**
     * @return array
     */
    private function getDbColumns(): array
    {
        $properties = $this->getProperties();

        return $this->getColumns($properties, '@DbColumn');
    }

    /**
     * @return array
     */
    private function getImmutableDbColumns()
    {
        $properties = $this->getProperties();

        return $this->getColumns($properties, '@DbColumn(immutable)');
    }

    /**
     * @param ReflectionProperty[] $properties
     * @param string $needle
     * @return array
     */
    private function getColumns($properties, string $needle)
    {
        $columns = [];

        foreach ($properties as $property) {
            $property_doc_comment = $property->getDocComment();
            if (strpos($property_doc_comment, $needle) !== false) {
                $columns[] = $property->getName();
            }
        }

        return $columns;
    }

    /**
     * @param array $columns
     * @return array
     */
    private function getColumnsValues(array $columns)
    {
        $data = [];

        foreach ($columns as $field) {
            $data[$field] = $this->{$field};
        }

        return $data;
    }

    /**
     * @return ReflectionObject
     */
    private function getReflectionObject()
    {
        return new ReflectionObject($this);
    }

    /**
     * @param int|null $filter
     * @return ReflectionProperty[]
     */
    private function getProperties(int $filter = null)
    {
        return $this->getReflectionObject()->getProperties($filter);
    }
}