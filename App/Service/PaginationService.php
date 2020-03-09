<?php


namespace App\Service;


use App\Http\Request;
use App\Model\Paginator;
use App\Repository\AbstractRepository;

class PaginationService
{
    public function paginate(AbstractRepository $repository, Request $request, int $limit)
    {
        $current_page = $request->getIntFromGet('page', '1');
        $paginator = new Paginator($repository);
        $paginator->setCurrentPage($current_page)
            ->setStart($limit * ($current_page - 1))
            ->setLimit($limit);

        return $paginator;
    }

    /**
     * @param Paginator $paginator
     * @return int
     */
    public function pages(Paginator $paginator): int
    {
        return $paginator->getCountPages();
    }

    /**
     * @param Paginator $paginator
     * @return int
     */
    public function currentPage(Paginator $paginator)
    {
        return $paginator->getCurrentPage();
    }

    /**
     * @param Paginator $paginator
     * @return int
     */
    public function total(Paginator $paginator): int
    {
        return $paginator->count();
    }
}