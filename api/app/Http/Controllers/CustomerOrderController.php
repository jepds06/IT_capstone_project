<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerOrderStoreRequest;
use App\Http\Requests\CustomerOrderUpdateRequest;
use App\Interface\Service\CustomerOrderServiceInterface;
use Illuminate\Http\Request;

class CustomerOrderController extends Controller
{
    private $cstrOrderService;

    public function __construct(CustomerOrderServiceInterface $cstrOrderService)
    {
        $this->cstrOrderService = $cstrOrderService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->cstrOrderService->findCustomerOrders();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CustomerOrderStoreRequest $request)
    {
        return $this->cstrOrderService->createCustomerOrder($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $cstrOrderId)
    {
        return $this->cstrOrderService->findCustomerOrderById($cstrOrderId);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CustomerOrderUpdateRequest $request, int $cstrOrderId)
    {
        return $this->cstrOrderService->updateCustomerOrder($request, $cstrOrderId);
    }
}
