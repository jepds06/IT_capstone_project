<?php

namespace App\Service;

use App\Interface\Repository\AccountRepositoryInterface;
use App\Http\Resources\ProductMaterialsResource;
use App\Interface\Repository\ProductMaterialsRepositoryInterface;
use App\Interface\Service\ProductMaterialServiceInterface;

class ProductMaterialsService implements ProductMaterialServiceInterface
{
    private $productMaterialRepository;

    public function __construct(ProductMaterialsRepositoryInterface $productMaterialRepository)
    {
        $this->productMaterialRepository = $productMaterialRepository;
    }

    public function findProductMats()
    {
        $productMats = $this->productMaterialRepository->findMany();

        return ProductMaterialsResource::collection($productMats);
    }

    public function findProductMatsById(int $productMatsId)
    {
        $productMats = $this->productMaterialRepository->findOneById($productMatsId);

        return new ProductMaterialsResource($productMats);
    }
    
    public function createProductMats(object $payload)
    {
        $productMats = $this->productMaterialRepository->create($payload);

        return new ProductMaterialsResource($productMats);
    }

    public function updateProductMats(object $payload, int $productMatsId)
    {
        $productMats = $this->productMaterialRepository->update($payload, $productMatsId);

        return new ProductMaterialsResource($productMats);
    }

    public function findProdMatsByProductId(int $productId)
    {
        $productMats = $this->productMaterialRepository->findMaterialsByProductId($productId);
        
        return $productMats;
    }
}