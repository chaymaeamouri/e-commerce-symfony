<?php

namespace App\Service;

use Symfony\Component\DependencyInjection\Attribute\Autowire;

class CartHandler
{
    private $cartStrategy;

    public function __construct(
        #[Autowire(service: SessionCart::class)]
        CartInterface $cartStrategy
    )
    {
        $this->cartStrategy = $cartStrategy;
    }

    public function add(int $id): void
    {
        $this->cartStrategy->add($id);
    }

    public function remove(int $id): void
    {
        $this->cartStrategy->remove($id);
    }

    public function decrement(int $id): void
    {
        $this->cartStrategy->decrement($id);
    }

    public function clear(): void
    {
        $this->cartStrategy->clear();
    }

    public function getTotal(): float
    {
        return $this->cartStrategy->getTotal();
    }

    public function getFullCart(): array
    {
        return $this->cartStrategy->getFullCart();
    }

    public function getTotalQuantity(): int
    {
        return $this->cartStrategy->getTotalQuantity();
    }
}
