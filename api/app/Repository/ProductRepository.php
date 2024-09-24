<?php

namespace App\Repository;

use App\Interface\Repository\ProductRepositoryInterface;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Response;

class ProductRepository implements ProductRepositoryInterface
{
    public function findMany()
    {
        return Product::paginate(10);
    }

    public function findOneById(int $productId)
    {
        return Product::findOrFail($productId);
    }

    public function create(object $payload)
    {
        $product = new Product();
        $product->productName = $payload->productName;
        $product->specifications = $payload->specifications;
        $product->unitPrice = $payload->unitPrice;
        $prodCategory = ProductCategory::find($payload->prodCatID);

        if($prodCategory){
            $product->prdCategory()->associate($prodCategory);
        } else {
            // Handle the error: throw an exception, return an error response, or set a default value
            throw new \Exception("Invalid account type ID provided.");
        }

        $product->save();

        return $product->fresh();
    }

    public function update(object $payload, int $productId)
    {
        $product = Product::findOrFail($productId);
        $product->productName = $payload->productName;
        $product->specifications = $payload->specifications;
        $product->unitPrice = $payload->unitPrice;
        $prodCategory = ProductCategory::find($payload->prodCatID);

        if($prodCategory){
            $product->prdCategory()->associate($prodCategory);
        } else {
            // Handle the error: throw an exception, return an error response, or set a default value
            throw new \Exception("Invalid account type ID provided.");
        }

        $product->save();

        return $product->fresh();
    }

    public function delete(int $productId)
    {
        $product = Product::findOrFail($productId);
        $product->delete();

        return response()->json([
            'message' => 'Successfully Deleted'
        ], Response::HTTP_OK);
    }
}