<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReturnProdOrderStoreRequest;
use App\Http\Requests\ReturnProdOrderUpdateRequest;
use App\Interface\Service\ReturnProdOrderServiceInterface;
use Illuminate\Http\Request;

class ReturnProdOrderController extends Controller
{
    private $rtrnProdOrderService;

    public function __construct(ReturnProdOrderServiceInterface $rtrnProdOrderService)
    {
        $this->rtrnProdOrderService = $rtrnProdOrderService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->rtrnProdOrderService->findReturnProdOrders();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ReturnProdOrderStoreRequest $request)
    {
        return $this->rtrnProdOrderService->createRtrnProdOrder($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $rtrnPrdOrdId)
    {
        return $this->rtrnProdOrderService->findRtrnProdOrderById($rtrnPrdOrdId);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ReturnProdOrderUpdateRequest $request, int $rtrnPrdOrdId)
    {
        return $this->rtrnProdOrderService->updateRtrnProdOrder($request, $rtrnPrdOrdId);
    }
}
