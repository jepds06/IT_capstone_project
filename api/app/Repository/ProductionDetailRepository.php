<?php

namespace App\Repository;

use App\Interface\Repository\ProductionDetailRepositoryInterface;
use App\Models\Product;
use App\Models\Production;
use App\Models\ProductionDetail;
use App\Models\ProductionMaterial;
use App\Models\ProductMaterial;
use Exception;
use Illuminate\Support\Facades\DB;

class ProductionDetailRepository implements ProductionDetailRepositoryInterface
{
    public function findMany()
    {
        return ProductionDetail::paginate(10);
    }

    public function findOneById(int $prodtnDetailId)
    {
        return ProductionDetail::findOrFail($prodtnDetailId);
    }

    public function create(object $payload)
    {
        // Begin transaction
        DB::beginTransaction();

        try {
            // Create a new production detail record manually
            $prodtnDetail = new ProductionDetail();
            $production = Production::find($payload->productionID);
            if ($production) {
                $prodtnDetail->productionID = $production->productionID;
            } else {
                throw new \Exception("Invalid production ID provided.");
            }

            $product = Product::find($payload->productID);
            if ($product) {
                $prodtnDetail->productID = $product->productID;
            } else {
                throw new \Exception("Invalid product ID provided.");
            }

            $prodtnDetail->quantity = $payload->quantity;
            $prodtnDetail->status = $payload->status;
            $prodtnDetail->remarks = $payload->remarks;
            $prodtnDetail->save();

            // // Retrieve productMaterial manually
            // $productMaterial = ProductMaterial::find($payload->productID);
            // if (!$productMaterial) {
            //     throw new Exception("No product material found for the given productID.");
            // }

            // // Create a new production material record
            // $prodtnMaterial = new ProductionMaterial();
            // $prodtnMaterial->productMatsID = $productMaterial->productMatsID; // Assign productMatsID
            // $prodtnMaterial->prodtnDetailID = $prodtnDetail->prodtnDetailID;  // Assign prodtnDetailID

            // // Calculate qtyNeeded (multiplying production quantity and product material quantity)
            // $prodtnMaterial->qtyNeeded = $prodtnDetail->quantity * $productMaterial->quantity;

            // // Set status and save production material
            // $prodtnMaterial->status = $payload->status;
            // $prodtnMaterial->save();

            // Retrieve product materials for the given product
            $productMaterials = ProductMaterial::where('productID', $payload->productID)->get();
            if ($productMaterials->isEmpty()) {
                throw new Exception("No product materials found for the given productID.");
            }

            // Prepare production materials for bulk insert
            $prodtnMaterials = $productMaterials->map(function ($productMaterial) use ($prodtnDetail, $payload) {
                return [
                    'productMatsID' => $productMaterial->productMatsID,
                    'prodtnDetailID' => $prodtnDetail->prodtnDetailID,
                    'qtyNeeded' => $prodtnDetail->quantity * $productMaterial->quantity,
                    'status' => $payload->status,
                ];
            })->toArray();

            // Insert multiple production materials at once
            ProductionMaterial::insert($prodtnMaterials);
            // Commit the transaction if all is successful
            DB::commit();

            return $prodtnDetail->fresh(); // Return fresh production detail record
        } catch (Exception $e) {
            // Rollback transaction on error
            DB::rollBack();
            throw new Exception("Error creating records: " . $e->getMessage());
        }
    }

    public function update(object $payload, int $prodtnDetailId)
    {
        try {
            // Retrieve the production detail record or fail
            $prodtnDetail = ProductionDetail::findOrFail($prodtnDetailId);
    
            // Validate and associate the production
            $production = Production::find($payload->productionID);
            if (!$production) {
                throw new \Exception("Invalid production ID provided.");
            }
            $prodtnDetail->production()->associate($production);
    
            // Validate and associate the product
            $product = Product::find($payload->productID);
            if (!$product) {
                throw new \Exception("Invalid product ID provided.");
            }
            $prodtnDetail->product()->associate($product);
    
            // Update fields in production detail
            $prodtnDetail->quantity = $payload->quantity;
            $prodtnDetail->status = $payload->status;
            $prodtnDetail->remarks = $payload->remarks;
    
            // Save the updated production detail
            $prodtnDetail->save();
    
            // Retrieve product materials for the given product
            $productMaterials = ProductMaterial::where('productID', $payload->productID)->get();
            if ($productMaterials->isEmpty()) {
                throw new Exception("No product materials found for the given productID.");
            }
    
            // Prepare production materials for update
            $prodtnMaterials = $productMaterials->map(function ($productMaterial) use ($prodtnDetail, $payload) {
                return [
                    'productMatsID' => $productMaterial->productMatsID,
                    'prodtnDetailID' => $prodtnDetail->prodtnDetailID,
                    'qtyNeeded' => $prodtnDetail->quantity * $productMaterial->quantity,
                    'status' => $payload->status,
                ];
            });
    
            // Update or insert production materials
            foreach ($prodtnMaterials as $material) {
                ProductionMaterial::updateOrCreate(
                    ['prodtnDetailID' => $prodtnDetail->prodtnDetailID, 'productMatsID' => $material['productMatsID']],
                    $material
                );
            }
    
            // Commit the transaction
            DB::commit();
    
            return $prodtnDetail->fresh(); // Return fresh production detail record
    } catch (Exception $e) {
        // Rollback transaction on error
        DB::rollBack();
        throw new Exception("Error updating records: " . $e->getMessage());
    }
    }

    public function findListByProductionId(int $productionID)
    {
        $production = Production::with('productionDetails.productionMaterials', 'productionDetails.product')->find($productionID);

        if (!$production) {
            return response()->json(['message' => 'Production not found'], 404);
        }

        return response()->json($production);
    }
}