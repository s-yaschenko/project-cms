<?php


namespace App\Controller;


use App\Http\Response;
use App\Repository\FolderRepository;
use App\Repository\ProductRepository;
use App\Repository\VendorRepository;

class ProductController extends AbstractController
{
    private const PER_PAGE = 9;

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

    /**
     * @Route(url="/product/create")
     *
     * @param ProductRepository $product_repository
     * @param VendorRepository $vendor_repository
     * @param FolderRepository $folder_repository
     * @return Response
     */
    public function create(ProductRepository $product_repository, VendorRepository $vendor_repository, FolderRepository $folder_repository)
    {
        $product = $product_repository->createNewEntity();
        $vendors = $vendor_repository->findAll();
        $folders = $folder_repository->findAll();

        $request = $this->getRequest();
        if ($request->isPostData()) {
            $name = $request->getStringFromPost('name');
            $price = $request->getFloatFromPost('price');
            $amount = $request->getIntFromPost('amount');
            $description = $request->getStringFromPost('description');
            $vendor_id = $request->getIntFromPost('vendor_id');
            $folder_ids = $request->getArrayFromPost('folder_ids');

            if (!$name || !$price || !$amount) {
                $this->getFlashMessageService()->message('danger', 'Заполнены не все обязательные поля!');
                return $this->redirect($request->getRefererUrl());
            }

            $product->setName($name);
            $product->setPrice($price);
            $product->setAmount($amount);
            $product->setDescription($description);
            $product->setVendorId($vendor_id);

            foreach ($folder_ids as $folder_id) {
                $product->addFolderId($folder_id);
            }

            $product_repository->save($product);

            $this->getFlashMessageService()->message('success', "Товар: '{$name}' добавлен!");

            return $this->redirect('/products');
        }

        return $this->render('product/product.tpl', [
            'product' => $product,
            'vendors' => $vendors,
            'folders' => $folders
        ]);
    }

}