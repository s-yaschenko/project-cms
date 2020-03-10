<?php


namespace App\Factory;


use App\Http\Request;
use App\Model\Paginator;
use App\Repository\AbstractRepository;

class PaginationFactory
{
    public function paginate(AbstractRepository $repository, Request $request, int $limit)
    {
        $current_page = $request->getIntFromGet('page', '1');
        $paginator = new Paginator($repository);
        $paginator->setCurrentPage($current_page)
            ->setStart($limit * ($current_page - 1))
            ->setLimit($limit)
            ->setCountPages()
            ->setItems();

        return $paginator;
    }
}