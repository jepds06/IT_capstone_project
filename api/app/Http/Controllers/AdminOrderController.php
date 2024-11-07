<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminOrderStoreRequest;
use App\Http\Requests\AdminOrderUpdateRequest;
use App\Interface\Service\AdminOrderServiceInterface;

class AdminOrderController extends Controller
{
    private $adminOrderService;

    public function __construct(AdminOrderServiceInterface $adminOrderService)
    {
        $this->adminOrderService = $adminOrderService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->adminOrderService->findAdminOrder();
    }

        /**
     * Display a listing of the resource by productionID.
     */
    public function indexByProductionID(int $produtionID)
    {
        return $this->adminOrderService->findAdminOrderByProductionID($produtionID);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(AdminOrderStoreRequest $request)
    {
        return $this->adminOrderService->createAdminOrder($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $adminOrderId)
    {
        return $this->adminOrderService->findAdminOrdertById($adminOrderId);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AdminOrderUpdateRequest $request, int $adminOrderId)
    {
        return $this->adminOrderService->updateAdminOrder($request, $adminOrderId);
    }
}
