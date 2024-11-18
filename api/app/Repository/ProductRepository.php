<?php

namespace App\Repository;

use App\Interface\Repository\ProductRepositoryInterface;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

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

        //handle image upload
        if(isset($payload->image) && $payload->image instanceof UploadedFile){
            //store the image file from request into imagePath table column
            $product->imagePath = $this->handleImageUpload($payload->image, $product->productID);
        }

        $prodCategory = ProductCategory::find($payload->prodCatID);
        if($prodCategory){
            $product->prdCategory()->associate($prodCategory);
        } else {
            // Handle the error: throw an exception, return an error response, or set a default value
            throw new \Exception("Invalid product category ID provided.");
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

        //handle image upload
        if(isset($payload->image) && $payload->image instanceof UploadedFile){
            //delete old image if exists
            if($product->imagePath){
                Storage::disk('public')->delete($product->imagePath);
            }
            //store the image file from request into imagePath table column
            $product->imagePath = $this->handleImageUpload($payload->image, $product->productID);
        }

        $prodCategory = ProductCategory::find($payload->prodCatID);
        if($prodCategory){
            $product->prdCategory()->associate($prodCategory);
        } else {
            // Handle the error: throw an exception, return an error response, or set a default value
            throw new \Exception("Invalid product category ID provided.");
        }

        $product->save();

        return $product->fresh();
    }

    private function handleImageUpload(UploadedFile $image, int $productId)
    {
        //filename generation
        $extension = $image->getClientOriginalExtension();
        $fileName = "product_{$productId}.{$extension}";

        return $image->storeAs('products', $fileName, 'public');
    }
}