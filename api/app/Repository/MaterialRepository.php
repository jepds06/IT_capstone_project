<?php

namespace App\Repository;

use App\Interface\Repository\MaterialRepositoryInterface;
use App\Models\Material;
use Illuminate\Http\Response;

class MaterialRepository implements MaterialRepositoryInterface
{
    public function findMany()
    {
        return Material::paginate(10);
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
}