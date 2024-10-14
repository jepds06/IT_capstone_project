<?php

namespace App\Service;

use App\Http\Resources\MaterialResource;
use App\Interface\Repository\MaterialRepositoryInterface;
use App\Interface\Service\MaterialServiceInterface;

class MaterialService implements MaterialServiceInterface
{
    private $materialRepository;

    public function __construct(MaterialRepositoryInterface $materialRepository)
    {
        $this->materialRepository = $materialRepository;
    }

    public function findMaterials()
    {
        $materials = $this->materialRepository->findMany();

        return MaterialResource::collection($materials);
    }

    public function findMaterialById(int $materialId)
    {
        $materials = $this->materialRepository->findOneById($materialId);

        return new MaterialResource($materials);
    }
    
    public function createMaterial(object $payload)
    {
        $materials = $this->materialRepository->create($payload);

        return new MaterialResource($materials);
    }

    public function updateMaterial(object $payload, int $materialId)
    {
        $materials = $this->materialRepository->update($payload, $materialId);

        return new MaterialResource($materials);
    }
    public function findMaterialsFromProduction($productionID)
    {
        $materials = $this->materialRepository->findMaterialFromProductionID($productionID);

        return $materials;
    }
}