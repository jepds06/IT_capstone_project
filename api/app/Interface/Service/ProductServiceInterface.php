<?php

namespace App\Interface\Service;

interface ProductServiceInterface
{
    public function findProducts();

    public function findProductById(int $productId);

    public function createProduct(object $payload);

    public function updateProduct(object $payload, int $productId);
}