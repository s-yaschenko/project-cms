<?php


namespace App\Model;


use App\Repository\AbstractRepository;

class Paginator
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
     * @return $this
     */
    public function setStart(int $start)
    {
        $this->start = $start;

        return $this;
    }

    /**
     * @param int $limit
     */
    public function setLimit(int $limit)
    {
        $this->limit = $limit;

        $this->items = $this->getRepository()->findAllWithLimit($limit, $this->start);
    }

    /**
     * @return int
     */
    public function getCountPages():int
    {
        return (int) ceil($this->count() / $this->limit);
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
     * @param $name
     * @return mixed
     */
    public function __get($name)
    {
        return $this->{$name};
    }

    /**
     * @return AbstractRepository
     */
    private function getRepository(): AbstractRepository
    {
        return $this->repository;
    }
}