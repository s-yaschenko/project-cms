<?php


namespace App\Controller;


use App\Http\Response;
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
}