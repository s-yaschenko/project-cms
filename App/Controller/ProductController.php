<?php


namespace App\Controller;

use App\Factory\PaginationFactory;
use App\Http\Request;
use App\Http\Response;
use App\Model\Product;
use App\Repository\FolderRepository;
use App\Repository\ProductRepository;
use App\Repository\VendorRepository;
use App\Service\UserService;

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
    public function list(ProductRepository $product_repository, VendorRepository $vendor_repository, FolderRepository $folder_repository, PaginationFactory $pagination)
    {
        $products = $pagination->paginate($product_repository, $this->getRequest(), self::PER_PAGE);
        $vendors = $vendor_repository->findAll();
        $folders = $folder_repository->findAll();

        return $this->render('product/list.tpl', [
            'products' => $products,
            'vendors' => $vendors,
            'folders' => $folders
        ]);
    }

    /**
     * @Route(url="/product/create")
     *
     * @param ProductRepository $product_repository
     * @param VendorRepository $vendor_repository
     * @param FolderRepository $folder_repository
     * @param UserService $user_service
     * @return Response
     */
    public function create(ProductRepository $product_repository, VendorRepository $vendor_repository, FolderRepository $folder_repository, UserService $user_service)
    {
        $this->checkUserAccess($user_service, 'Авторизуйтесь для добавления товара');

        $product = $product_repository->createNewEntity();
        $vendors = $vendor_repository->findAll();
        $folders = $folder_repository->findAll();

        $request = $this->getRequest();
        if ($request->isPostData()) {

            $product = $this->setProductDataFromRequest($product, $request);

            $product_repository->save($product);

            $this->getFlashMessageService()->message('success', "Товар: '{$product->getName()}' добавлен!");

            return $this->redirect('/products');
        }

        return $this->render('product/product.tpl', [
            'product' => $product,
            'vendors' => $vendors,
            'folders' => $folders
        ]);
    }

    /**
     * @Route(url="/product/edit/{product_id}")
     *
     * @param ProductRepository $product_repository
     * @param VendorRepository $vendor_repository
     * @param FolderRepository $folder_repository
     * @param UserService $user_service
     * @return Response
     */
    public function edit(ProductRepository $product_repository, VendorRepository $vendor_repository, FolderRepository $folder_repository, UserService $user_service)
    {
        $this->checkUserAccess($user_service, 'Авторизуйтесь для обновления товара');

        $product = $product_repository->find($this->getRoute()->getParam('product_id'));
        $vendors = $vendor_repository->findAll();
        $folders = $folder_repository->findAll();

        $request = $this->getRequest();
        if ($request->isPostData()) {

            $product = $this->setProductDataFromRequest($product, $request);

            $product_repository->save($product);

            $this->getFlashMessageService()->message('success', "Товар: '{$product->getName()}' обновлен!");

            return $this->redirect('/products');
        }

        return $this->render('product/product.tpl', [
            'product' => $product,
            'vendors' => $vendors,
            'folders' => $folders
        ]);
    }

    /**
     * @Route(url="/product/{product_id}")
     *
     * @param ProductRepository $product_repository
     * @return Response
     */
    public function view(ProductRepository $product_repository, VendorRepository $vendor_repository, FolderRepository $folder_repository)
    {
        $product_id = $this->getRoute()->getParam('product_id');

        $product = $product_repository->find($product_id);

        if (is_null($product)) {
            $this->getFlashMessageService()->message('info', 'Товар не найден!');
            return $this->redirect('/products');
        }

        $vendors = $vendor_repository->findAll();
        $folders = $folder_repository->findAll();

        return $this->render('product/view.tpl', [
            'product' => $product,
            'vendors' => $vendors,
            'folders' => $folders
        ]);
    }


    /**
     * @param Product $product
     * @param Request $request
     * @return Response|Product
     */
    private function setProductDataFromRequest(Product $product, Request $request)
    {
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

        return $product;
    }

}