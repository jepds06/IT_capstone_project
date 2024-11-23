<?php

namespace App\Repository;

use App\Interface\Repository\MaterialRepositoryInterface;
use App\Models\Material;
use App\Models\ProductionDetail;
use Illuminate\Http\Response;

class MaterialRepository implements MaterialRepositoryInterface
{
    public function findMany()
    {
        return Material::paginate(100);
    }

    public function findOneById(int $materialId)
    {
        return Material::findOrFail($materialId);
    }

    public function create(object $payload) 
    {
        $material = new Material();
        $material->description = $payload->description;
        $material->specification = $payload->specification;
        $material->brand = $payload->brand;
        $material->unitOfMeasure = $payload->unitOfMeasure;
       
        $material->save();

        return $material->fresh();
    }

    public function update(object $payload, int $materialId)
    {
        $material = Material::findOrFail($materialId);
        $material->description = $payload->description;
        $material->specification = $payload->specification;
        $material->brand = $payload->brand;
        $material->unitOfMeasure = $payload->unitOfMeasure;
           
        $material->save();

        return $material->fresh();
    }

    public function delete(int $materialId)
    {
        $material = Material::findOrFail($materialId);
        $material->delete();

        return response()->json([
            'message' => 'Successfully Deleted'
        ], Response::HTTP_OK);
    }

    public function findMaterialFromProductionID($productionID)
    {
        // Get the production details for the given productionID
        $productionDetails = ProductionDetail::with(['productionMaterials.productMaterial.material', 'productionMaterials.productMaterial.product'])
            ->where('productionID', $productionID)
            ->get();

        // Map through production details to get materials for each product
        $result = $productionDetails->flatMap(function ($productionDetail) {
            return $productionDetail->productionMaterials->map(function ($productionMaterial) {
                return [
                    'productID' => $productionMaterial->productMaterial->product->productID, // Ensure this matches your Product model
                    'productName' => $productionMaterial->productMaterial->product->productName, // Get the productName
                    'prodtnMtrlID' => $productionMaterial->prodtnMtrlID,
                    'qtyNeeded' => $productionMaterial->qtyNeeded,
                    'materialID' => $productionMaterial->productMaterial->material->materialID,
                    'description' => $productionMaterial->productMaterial->material->description,
                    'specification' => $productionMaterial->productMaterial->material->specification,
                    'brand' => $productionMaterial->productMaterial->material->brand,
                    'unitOfMeasure' => $productionMaterial->productMaterial->material->unitOfMeasure,
                ];
            });
        });

        return response()->json($result);
    }
}