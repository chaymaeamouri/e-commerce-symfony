<?php

namespace App\Service;

interface CartInterface
{
    public function add(int $id): void;
    public function remove(int $id): void;
    public function decrement(int $id): void;
    public function clear(): void;
    public function getTotal(): float;
    public function getFullCart(): array;
    public function getTotalQuantity(): int;
}
