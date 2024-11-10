<?php

namespace App\Http\Controllers;

use App\Http\Requests\SalesProdOrderStoreRequest;
use App\Http\Requests\SalesProdOrderUpdateRequest;
use App\Interface\Service\SalesPrdOrdServiceInterface;
use Illuminate\Http\Request;

class SalesProductOrderController extends Controller
{
    private $slsPrdOrdService;

    public function __construct(SalesPrdOrdServiceInterface $slsPrdOrdService)
    {
        $this->slsPrdOrdService = $slsPrdOrdService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->slsPrdOrdService->findSalesPrdOrders();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SalesProdOrderStoreRequest $request)
    {
        return $this->slsPrdOrdService->createSalesPrdOrder($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $slsPrdOrdId)
    {
        return $this->slsPrdOrdService->findSalesPrdOrderById($slsPrdOrdId);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SalesProdOrderUpdateRequest $request, int $slsPrdOrdId)
    {
        return $this->slsPrdOrdService->updateSalesPrdOrder($request, $slsPrdOrdId);
    }
}
