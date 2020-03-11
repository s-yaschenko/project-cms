<?php


namespace App\Service;


use App\Http\Session;
use App\Model\Cart;
use App\Model\Product;

class CartService
{
    /**
     * @var string
     */
    private $session_key = 'shop_cart';

    /**
     * @var Session
     */
    private $session;

    /**
     * @var Cart
     */
    private $cart;

    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    /**
     * @return Cart
     */
    public function getCart(): Cart
    {
        if (!($this->cart instanceof Cart)) {
            if ($this->isCartExit()) {
                $cart = $this->getSession()->getDataSessionByKey($this->getSessionKey());

                $this->cart = unserialize($cart);
            } else {
                $this->cart = new Cart();
            }
        }

        return $this->cart;
    }

    /**
     * @param Product $product
     */
    public function addProduct(Product $product)
    {
        $cart = $this->getCart();
        $cart->add($product);

        $this->storeCart();
    }

    public function clearCart()
    {
        $this->getSession()->unsetDataSessionByKey($this->getSessionKey());
    }

    /**
     * @return string
     */
    private function getSessionKey(): string
    {
        return $this->session_key;
    }

    private function storeCart()
    {
        $serialized_cart = serialize($this->getCart());

        $this->getSession()->setSessionByKey($this->getSessionKey(), $serialized_cart);
    }

    /**
     * @return bool
     */
    private function isCartExit(): bool
    {
        return $this->getSession()->isDataSessionByKey($this->getSessionKey());
    }

    /**
     * @return Session
     */
    private function getSession(): Session
    {
        return $this->session;
    }
}