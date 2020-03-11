<?php


namespace App\Model;


class CartItem
{
    /**
     * @var Product
     */
    private $product;

    /**
     * @var int
     */
    private $amount;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    /**
     * @return Product
     */
    public function getProduct(): Product
    {
        return $this->product;
    }

    /**
     * @return int
     */
    public function getAmount(): int
    {
        return $this->amount;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        $price = $this->getProduct()->getPrice() * $this->getAmount();

        return $price;
    }

    /**
     * @param int $amount
     */
    public function setAmount(int $amount): void
    {
        $this->amount = $amount;
    }

    /**
     * @param int $amount
     */
    public function incrementAmount(int $amount = 1): void
    {
        $this->amount += $amount;
    }

    public function decrementAmount(): void
    {
        $this->amount--;
    }
}