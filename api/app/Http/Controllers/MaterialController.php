<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\MaterialStoreRequest;
use App\Http\Requests\MaterialUpdateRequest;
use App\Interface\Service\MaterialServiceInterface;

class MaterialController extends Controller
{
    private $materialService;

    public function __construct(MaterialServiceInterface $materialService)
    {
        $this->materialService = $materialService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->materialService->findMaterials();
    }

     /**
     * Display a listing of the resource.
     */
    public function indexByProductionID($productionID)
    {
        return $this->materialService->findMaterialsFromProduction($productionID);
    }
 
    /**
     * Store a newly created resource in storage.
     */
    public function store(MaterialStoreRequest $request)
    {
        return $this->materialService->createMaterial($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $materialId)
    {
        return $this->materialService->findMaterialByID($materialId);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MaterialUpdateRequest $request, int $materialId)
    {
        return $this->materialService->updateMaterial($request, $materialId);
    }
}
