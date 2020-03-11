<?php


namespace App\Model;


class Cart
{
    /**
     * @var CartItem[]
     */
    private $cart_items = [];

    /**
     * @return int
     */
    public function getAmount(): int
    {
        $amount = 0;

        foreach ($this->getCartItems() as $cart_item) {
            $amount += $cart_item->getAmount();
        }

        return $amount;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        $price = 0;

        foreach ($this->getCartItems() as $cart_item) {
            $price += $cart_item->getPrice();
        }

        return $price;
    }

    /**
     * @param Product $product
     */
    public function add(Product $product)
    {
        $cart_item = $this->getItem($product);
        $cart_item->incrementAmount();
        $this->addCartItem($cart_item);
    }

    /**
     * @param Product $product
     */
    public function delete(Product $product)
    {
        $cart_item = $this->getItem($product);
        $this->deleteCartItem($cart_item);
    }

    /**
     * @return int
     */
    public function getCountCartItems(): int
    {
        return count($this->getCartItems());
    }

    /**
     * @return CartItem[]
     */
    public function getCartItems(): array
    {
        return $this->cart_items;
    }

    /**
     * @param Product $product
     * @return CartItem
     */
    private function getItem(Product $product): CartItem
    {
        $product_id = $product->getId();

        return $this->cart_items[$product_id] ?? new CartItem($product);
    }

    /**
     * @param CartItem $cart_item
     */
    private function addCartItem(CartItem $cart_item)
    {
        $product_id = $cart_item->getProduct()->getId();

        $this->cart_items[$product_id] = $cart_item;
    }

    /**
     * @param CartItem $cart_item
     */
    private function deleteCartItem(CartItem $cart_item)
    {
        $product_id = $cart_item->getProduct()->getId();

        unset($this->cart_items[$product_id]);
    }

}