<?php


namespace App\Controller;


use App\Http\Response;
use App\Repository\ProductRepository;
use App\Service\CartService;

class CartController extends AbstractController
{

    /**
     * @Route(url="/cart/clear")
     *
     * @param CartService $cart_service
     * @return Response
     */
    public function clear(CartService $cart_service)
    {
        $cart_service->clearCart();

        return $this->redirect($this->getRequest()->getRefererUrl());
    }

    /**
     * @Route(url="/cart/delete/{product_id}")
     *
     * @param CartService $cart_service
     * @param ProductRepository $product_repository
     * @return Response
     */
    public function delete(CartService $cart_service, ProductRepository $product_repository)
    {
        $product_id = $this->getRoute()->getParam('product_id');

        $product = $product_repository->find($product_id);

        $cart_service->deleteProduct($product);

        return $this->redirect($this->getRequest()->getRefererUrl());
    }

    /**
     * @Route(url="/cart")
     *
     * @param CartService $cart_service
     * @return Response
     */
    public function view(CartService $cart_service)
    {
        $cart_items = $cart_service->getCart()->getCartItems();

        return $this->render('cart.tpl', [
            'cart_items' => $cart_items
        ]);
    }
}