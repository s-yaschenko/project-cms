<?php


namespace App\Model;


use App\Repository\AbstractRepository;

class Paginator implements \ArrayAccess
{
    /**
     * @var AbstractRepository
     */
    private $repository;

    /**
     * @var int
     */
    private $current_page;

    /**
     * @var int
     */
    private $start;

    /**
     * @var int
     */
    private $limit;

    /**
     * @var int
     */
    private $count_pages;

    /**
     * @var array
     */
    private $items;

    public function __construct(AbstractRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param int $current_page
     * @return $this
     */
    public function setCurrentPage(int $current_page)
    {
        $this->current_page = $current_page;

        return $this;
    }

    /**
     * @param int $start
     * @return Paginator
     */
    public function setStart(int $start): Paginator
    {
        $this->start = $start;

        return $this;
    }

    /**
     * @param int $limit
     * @return Paginator
     */
    public function setLimit(int $limit): Paginator
    {
        $this->limit = $limit;

        return $this;
    }

    /**
     * @return Paginator
     */
    public function setItems(): Paginator
    {
        $limit = $this->getLimit();
        $start = $this->getStart();

        $this->items = $this->getRepository()->findAllWithLimit($limit, $start);

        return $this;
    }

    /**
     * @return int
     */
    public function getCountPages():int
    {
        $this->count_pages = (int) ceil($this->count() / $this->getLimit());

        return $this->count_pages;
    }

    /**
     * @return int
     */
    public function getCurrentPage(): int
    {
        return $this->current_page;
    }

    /**
     * @return int
     */
    public function count(): int
    {
        return $this->getRepository()->getCount();
    }

    /**
     * @return array
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @return int
     */
    public function getCountPage(): int
    {
        return $this->count_pages;
    }

    /**
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        return method_exists($this, $offset);
    }

    /**
     * @param mixed $offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return $this->{$offset};
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {
        $this->{$offset} = $value;
    }

    /**
     * @inheritDoc
     */
    public function offsetUnset($offset)
    {
        // TODO: Implement offsetUnset() method.
    }

    /**
     * @return int
     */
    private function getLimit(): int
    {
        return $this->limit;
    }

    /**
     * @return int
     */
    private function getStart(): int
    {
        return $this->start;
    }

    /**
     * @return AbstractRepository
     */
    private function getRepository(): AbstractRepository
    {
        return $this->repository;
    }
}