<?php

namespace App\Http\Controllers;

use App\Http\Requests\SalesDeliveryStoreRequest;
use App\Http\Requests\SalesDeliveryUpdateRequest;
use App\Interface\Service\SalesDeliveryServiceInterface;
use Illuminate\Http\Request;

class SalesDeliveryController extends Controller
{
    private $slsDeliveryService;

    public function __construct(SalesDeliveryServiceInterface $slsDeliveryService)
    {
        $this->slsDeliveryService = $slsDeliveryService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->slsDeliveryService->findSalesDeliveries();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SalesDeliveryStoreRequest $request)
    {
        return $this->slsDeliveryService->createSlsDelivery($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $deliveryId)
    {
        return $this->slsDeliveryService->findSlsDeliveryById($deliveryId);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SalesDeliveryUpdateRequest $request, int $deliveryId)
    {
        return $this->slsDeliveryService->updateSlsDelivery($request, $deliveryId);
    }
}
