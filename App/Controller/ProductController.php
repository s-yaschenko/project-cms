<?php


namespace App\Controller;


use App\Http\Response;
use App\Repository\FolderRepository;
use App\Repository\ProductRepository;
use App\Repository\VendorRepository;

class ProductController extends AbstractController
{
    private const PER_PAGE = 10;

    /**
     * @Route(url="/products")
     *
     * @param ProductRepository $product_repository
     * @param VendorRepository $vendor_repository
     * @param FolderRepository $folder_repository
     * @return Response
     */
    public function list(ProductRepository $product_repository, VendorRepository $vendor_repository, FolderRepository $folder_repository)
    {
        $current_page = $this->getRequest()->getIntFromGet('page', 1);

        $start = self::PER_PAGE * ($current_page - 1);

        $products = [
            'count' => $product_repository->getCount(),
            'items' => $product_repository->findAllWithLimit(self::PER_PAGE, $start)
        ];

        $vendors = $vendor_repository->findAll();
        $folders = $folder_repository->findAll();

        $paginator = [
            'pages' => ceil($products['count'] / self::PER_PAGE),
            'current' => $current_page
        ];

        return $this->render('product/list.tpl', [
            'products' => $products,
            'vendors' => $vendors,
            'folders' => $folders,
            'paginator' => $paginator
        ]);
    }
}