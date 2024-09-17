<?php

namespace App\Service;

use App\Http\Resources\ProductCategoryResource;
use App\Interface\Repository\ProductCategoryRepositoryInterface;
use App\Interface\Service\ProductCategoryServiceInterface;

class ProductCategoryService implements ProductCategoryServiceInterface
{
    private $prodcatRepository;

    public function __construct(ProductCategoryRepositoryInterface $prodcatRepository)
    {
        $this->prodcatRepository = $prodcatRepository;
    }

    public function findProductCategory()
    {
        $prodCat = $this->prodcatRepository->findMany();

        return ProductCategoryResource::collection($prodCat);
    }

    public function findProdCatById(int $prodCatId)
    {
        $prodCat = $this->prodcatRepository->findOneById($prodCatId);

        return new ProductCategoryResource($prodCat);
    }
    
    public function createProductCategory(object $payload)
    {
        $prodCat = $this->prodcatRepository->create($payload);

        return new ProductCategoryResource($prodCat);
    }

    public function updateProductCategory(object $payload, int $prodCatId)
    {
        $prodCat = $this->prodcatRepository->update($payload, $prodCatId);

        return new ProductCategoryResource($prodCat);
    }

}