<?php

namespace App\Service;

class ApiCart implements CartInterface
{
    public function add(int $id): void
    {
        // Simulate API call to add product
    }

    public function remove(int $id): void
    {
        // Simulate API call to remove product
    }

    public function decrement(int $id): void
    {
        // Simulate API call to decrement quantity
    }

    public function clear(): void
    {
        // Simulate API call to clear cart
    }

    public function getTotal(): float
    {
        return 0.0; // Simulate fetching total from API
    }

    public function getFullCart(): array
    {
        return []; // Simulate fetching full cart from API
    }

    public function getTotalQuantity(): int
    {
        return 0; // Simulate fetching total quantity from API
    }
}
