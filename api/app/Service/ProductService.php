<?php

namespace App\Service;

use App\Http\Resources\ProductResource;
use App\Interface\Repository\ProductRepositoryInterface;
use App\Interface\Service\ProductServiceInterface;

class ProductService implements ProductServiceInterface
{
    private $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function findProducts()
    {
        $products = $this->productRepository->findMany();

        return ProductResource::collection($products);
    }

    public function findProductById(int $productId)
    {
        $product = $this->productRepository->findOneById($productId);

        return new ProductResource($product);
    }

    public function createProduct(object $payload)
    {
        $product = $this->productRepository->create($payload);

        return new ProductResource($product);
    }

    public function updateProduct(object $payload, int $productId)
    {
        $product = $this->productRepository->update($payload, $productId);

        return new ProductResource($product);
    }
}