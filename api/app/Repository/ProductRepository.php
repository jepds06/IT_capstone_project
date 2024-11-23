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
         // Fetch paginated products
        $products = Product::with(['salesOrder'])->paginate(20);

        // Map through the products and append a full image URL
        $products->getCollection()->transform(function ($product) {
            if ($product->imagePath) {
                // Generate the full URL for the stored image
                $product->image_url = asset('storage/' . $product->imagePath);
            } else {
                $product->image_url = null; // Or set a default image URL
            }
            return $product;
        });

        return $products;
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
            $product->imagePath = $this->handleImageUpload($payload->image, $product->productName);
        }

        $prodCategory = ProductCategory::find($payload->prodCatID);
        if($prodCategory){
            $product->prdCategory()->associate($prodCategory);
        } else {
            // Handle the error: throw an exception, return an error response, or set a default value
            throw new \Exception("Invalid product category ID provided.");
        }

        $product->save();

        if ($product->imagePath) {
            // Generate the full URL for the stored image
            $product->image_url = asset('storage/' . $product->imagePath);
        } else {
            $product->image_url = null; // Or set a default image URL
        }
        return $product;

        return $product;
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
            $product->imagePath = $this->handleImageUpload($payload->image, $product->productName);
        }

        $prodCategory = ProductCategory::find($payload->prodCatID);
        if($prodCategory){
            $product->prdCategory()->associate($prodCategory);
        } else {
            // Handle the error: throw an exception, return an error response, or set a default value
            throw new \Exception("Invalid product category ID provided.");
        }

        $product->save();

            if ($product->imagePath) {
                // Generate the full URL for the stored image
                $product->image_url = asset('storage/' . $product->imagePath);
            } else {
                $product->image_url = null; // Or set a default image URL
            }
            return $product;

        return $product;
    }

    private function handleImageUpload(UploadedFile $image, string $productName)
    {
        //filename generation
        $extension = $image->getClientOriginalExtension();
        $fileName = "product_{$productName}.{$extension}";

        return $image->storeAs('products', $fileName, 'public');
    }
}