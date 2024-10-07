<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductionMaterialStoreRequest;
use App\Http\Requests\ProductionMaterialUpdateRequest;
use App\Interface\Service\ProductionMaterialServiceInterface;
use Illuminate\Http\Request;

class ProductionMaterialController extends Controller
{
    private $prodtnMaterialService;

    public function __construct(ProductionMaterialServiceInterface $prodtnMaterialService)
    {
        $this->prodtnMaterialService = $prodtnMaterialService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->prodtnMaterialService->findProductionMaterials();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductionMaterialStoreRequest $request)
    {
        return $this->prodtnMaterialService->createProductionMaterial($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $prodtnMtrlId)
    {
        return $this->prodtnMaterialService->findProductionMaterialById($prodtnMtrlId);
    }

    public function showProdDetailbyProdMatsID(int $prodtnMtrlId)
    {
        return $this->prodtnMaterialService->findProdtnDetailsByProdMatsId($prodtnMtrlId);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductionMaterialUpdateRequest $request, int $prodtnMtrlId)
    {
        return $this->prodtnMaterialService->updateProductionMaterial($request, $prodtnMtrlId);
    }
}
