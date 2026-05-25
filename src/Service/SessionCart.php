<?php

namespace App\Service;

use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\RequestStack;

class SessionCart implements CartInterface
{
    private $requestStack;
    private $productRepository;

    public function __construct(RequestStack $requestStack, ProductRepository $productRepository)
    {
        $this->requestStack = $requestStack;
        $this->productRepository = $productRepository;
    }

    private function getSession()
    {
        return $this->requestStack->getSession();
    }

    public function add(int $id): void
    {
        $cart = $this->getSession()->get('cart', []);
        if (!empty($cart[$id])) {
            $cart[$id]++;
        } else {
            $cart[$id] = 1;
        }
        $this->getSession()->set('cart', $cart);
    }

    public function remove(int $id): void
    {
        $cart = $this->getSession()->get('cart', []);
        if (!empty($cart[$id])) {
            unset($cart[$id]);
        }
        $this->getSession()->set('cart', $cart);
    }

    public function decrement(int $id): void
    {
        $cart = $this->getSession()->get('cart', []);
        if (!empty($cart[$id])) {
            if ($cart[$id] > 1) {
                $cart[$id]--;
            } else {
                unset($cart[$id]);
            }
        }
        $this->getSession()->set('cart', $cart);
    }

    public function clear(): void
    {
        $this->getSession()->remove('cart');
    }

    public function getTotal(): float
    {
        $total = 0;
        foreach ($this->getFullCart() as $item) {
            $total += $item['product']->getPrice() * $item['quantity'];
        }
        return $total;
    }

    public function getFullCart(): array
    {
        $cart = $this->getSession()->get('cart', []);
        $fullCart = [];
        foreach ($cart as $id => $quantity) {
            $product = $this->productRepository->find($id);
            if ($product) {
                $fullCart[] = [
                    'product' => $product,
                    'quantity' => $quantity
                ];
            }
        }
        return $fullCart;
    }

    public function getTotalQuantity(): int
    {
        $cart = $this->getSession()->get('cart', []);
        $totalQuantity = 0;
        foreach ($cart as $quantity) {
            $totalQuantity += $quantity;
        }
        return $totalQuantity;
    }
}
