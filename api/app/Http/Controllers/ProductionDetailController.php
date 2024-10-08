<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductionDetailStoreRequest;
use App\Http\Requests\ProductionDetailUpdateRequest;
use App\Interface\Service\ProductionDetailServiceInterface;
use Illuminate\Http\Request;

class ProductionDetailController extends Controller
{
    private $prodtnDetailService;

    public function __construct(ProductionDetailServiceInterface $prodtnDetailService)
    {
        $this->prodtnDetailService = $prodtnDetailService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->prodtnDetailService->findProductionDetails();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductionDetailStoreRequest $request)
    {
        return $this->prodtnDetailService->createProductionDetail($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $prodtnDetailId)
    {
        return $this->prodtnDetailService->findProductionDetailById($prodtnDetailId);
    }

    public function showByProductionID(int $productionID)
    {
        return $this->prodtnDetailService->findProductionDetailByProductionID($productionID);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductionDetailUpdateRequest $request, int $prodtnDetailId)
    {
        return $this->prodtnDetailService->updateProductionDetail($request, $prodtnDetailId);
    }
}
