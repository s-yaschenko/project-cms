<?php


namespace App\Controller;

use App\Http\Response;
use App\Repository\ProductRepository;

class SearchController extends AbstractController
{
    /**
     * @Route(url="/search")
     *
     * @param ProductRepository $product_repository
     * @return Response
     */
    public function search(ProductRepository $product_repository)
    {
        $name = $this->getRequest()->getStringFromGet('name');

        $products = $product_repository->searchProductByName($name);

        return $this->render('search.tpl', [
            'products' => $products
        ]);
    }
}