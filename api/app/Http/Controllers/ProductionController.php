<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductionStoreRequest;
use App\Http\Requests\ProductionUpdateRequest;
use App\Interface\Service\ProductionServiceInterface;
use Illuminate\Http\Request;

class ProductionController extends Controller
{
    private $productionService;

    public function __construct(ProductionServiceInterface $productionService)
    {
        $this->productionService = $productionService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->productionService->findProductions();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductionStoreRequest $request)
    {
        return $this->productionService->createProduction($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $productionId)
    {
        return $this->productionService->findProductionById($productionId);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductionUpdateRequest $request, int $productionId)
    {
        return $this->productionService->updateProduction($request, $productionId);
    }
}
