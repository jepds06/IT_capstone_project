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

            // Retrieve productMaterial manually
            $productMaterial = ProductMaterial::find($payload->productID);
            if (!$productMaterial) {
                throw new Exception("No product material found for the given productID.");
            }

            // Create a new production material record
            $prodtnMaterial = new ProductionMaterial();
            $prodtnMaterial->productMatsID = $productMaterial->productMatsID; // Assign productMatsID
            $prodtnMaterial->prodtnDetailID = $prodtnDetail->prodtnDetailID;  // Assign prodtnDetailID

            // Calculate qtyNeeded (multiplying production quantity and product material quantity)
            $prodtnMaterial->qtyNeeded = $prodtnDetail->quantity * $productMaterial->quantity;

            // Set status and save production material
            $prodtnMaterial->status = $payload->status;
            $prodtnMaterial->save();
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
        $prodtnDetail = ProductionDetail::findOrFail($prodtnDetailId);
        $production = Production::find($payload->productionID);

        if($production){
            $prodtnDetail->production()->associate($production);
        } else {
            throw new \Exception("Invalid production ID provided.");
        }
        
        $product = Product::find($payload->productID);
        if($product){
            $prodtnDetail->product()->associate($product);
        } else {
            throw new \Exception("Invalid product ID provided.");
        }
        $prodtnDetail->quantity = $payload->quantity;
        $prodtnDetail->status = $payload->status;
        $prodtnDetail->remarks = $payload->remarks;

        $prodtnDetail->save();

        return $prodtnDetail->fresh();
    }

    public function findListByProductionId(int $productionID)
    {
        $production = Production::with('productionDetails.productionMaterials')->find($productionID);

        if (!$production) {
            return response()->json(['message' => 'Production not found'], 404);
        }

        return response()->json($production);
    }
}