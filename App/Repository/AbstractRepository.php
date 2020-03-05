<?php


namespace App\Repository;


use App\Model\AbstractEntity;
use App\MySQL\Interfaces\IObjectDataManager;
use App\MySQL\Interfaces\ITableRow;
use App\QueryBuilder\Interfaces\IQueryBuilder;
use App\QueryBuilder\QueryBuilder;
use Exception;
use ReflectionException;
use ReflectionObject;

abstract class AbstractRepository
{
    /**
     * @var string
     */
    protected $model;

    /**
     * @var string
     */
    protected $table_name;

    /**
     * @var IObjectDataManager
     */
    private $object_data_manager;

    /**
     * @var QueryBuilder
     */
    private $query_builder;

    /**
     * AbstractRepository constructor.
     * @param IObjectDataManager $object_data_manager
     * @param IQueryBuilder $query_builder
     * @throws ReflectionException
     * @throws Exception
     */
    public function __construct(IObjectDataManager $object_data_manager, IQueryBuilder $query_builder)
    {
        if (!class_exists($this->model) || !in_array(AbstractEntity::class, class_parents($this->model))) {
            throw new Exception('Model should be a AbstractEntity');
        }

        $this->table_name = $this->getTableName();
        $this->object_data_manager = $object_data_manager;
        $this->query_builder = $query_builder;
    }

    /**
     * @param int $id
     * @return AbstractEntity|null
     */
    public function find(int $id)
    {
        $query = $this->getQueryBuilder()
            ->select()
            ->from($this->table_name)
            ->where('id', $id)
            ->getQuery();

        /**
         * @var AbstractEntity $entity
         */
        $entity = $this->getObjectDataManager()->fetchRow($query, $this->model);

        if (is_null($entity)) {
            return $entity;
        }

        return $this->modifyResultItem($entity);
    }

    /**
     * @return ITableRow[]|array
     */
    public function findAll()
    {
        $query = $this->getQueryBuilder()
            ->select()
            ->from($this->table_name)
            ->getQuery();

        $entities = $this->getObjectDataManager()->fetchAll($query, $this->model);

        return $this->modifyResultList($entities);
    }

    /**
     * @param string $column
     * @param string $value
     * @return ITableRow|null
     */
    public function findByColumnValue(string $column, string $value)
    {
        $odm = $this->getObjectDataManager();

        $value = $odm->escape($value);
        $query = $this->getQueryBuilder()
            ->select()
            ->from($this->table_name)
            ->where($column, $value)
            ->limit(0, 1)
            ->getQuery();

        /**
         * @var AbstractEntity $entity
         */
        $entity = $odm->fetchRow($query, $this->model);

        if (is_null($entity)) {
            return $entity;
        }

        return $this->modifyResultItem($entity);
    }

    /**
     * @param AbstractEntity $entity
     * @return AbstractEntity
     */
    public function save(AbstractEntity $entity): AbstractEntity
    {
        /**
         * @var AbstractEntity $result
         */
        $result = $this->getObjectDataManager()->save($entity);

        return $result;
    }


    /**
     * @param AbstractEntity $entity
     * @return int
     */
    public function delete(AbstractEntity $entity)
    {
        return $this->getObjectDataManager()->delete($entity);
    }

    /**
     * @return AbstractEntity
     */
    public function createNewEntity()
    {
        return new $this->model;
    }

    /**
     * @return int
     */
    public function getCount()
    {
        $query = $this->getQueryBuilder()
            ->select('COUNT(1) as count')
            ->from($this->table_name)
            ->getQuery();

        /**
         * @var $result AbstractEntity
         */
        $result = $this->getObjectDataManager()->fetchRow($query, $this->model);

        return (int) $result->getColumnValue('count') ?? 0;
    }

    /**
     * @param int $limit
     * @param int $start
     * @return array
     */
    public function findAllWithLimit(int $limit = 50, int $start = 0)
    {
        $query = "SELECT * FROM " . $this->table_name . " LIMIT $start, $limit";

        $result = $this->getObjectDataManager()->fetchAllHash($query, 'id', $this->model);

        return $this->modifyResultList($result);
    }

    /**
     * @return IObjectDataManager
     */
    protected function getObjectDataManager(): IObjectDataManager
    {
        return $this->object_data_manager;
    }

    /**
     * @return QueryBuilder
     */
    protected function getQueryBuilder(): QueryBuilder
    {
        return $this->query_builder;
    }

    /**
     * @return mixed
     * @throws ReflectionException
     */
    private function getTableName()
    {
        $model = new $this->model;
        $object = new ReflectionObject($model);
        $property = $object->getProperty('table_name');
        $property->setAccessible(true);

        return $property->getValue($model);
    }

    /**
     * @param AbstractEntity $entity
     * @return mixed
     */
    protected function modifyResultItem(AbstractEntity $entity) {
        $list = [
            0 => $entity,
        ];

        $result = $this->modifyResultList($list);

        return $result[0];
    }

    /**
     * @param array $result
     * @return array
     */
    protected function modifyResultList(array $result) {
        return $result;
    }
}