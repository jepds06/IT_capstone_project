<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminDeliveryStoreRequest;
use App\Http\Requests\AdminDeliveryUpdateRequest;
use App\Interface\Service\AdminDeliveryServiceInterface;
use Illuminate\Http\Request;

class AdminDeliveryController extends Controller
{
    private $adminDlvrService;

    public function __construct(AdminDeliveryServiceInterface $adminDlvrService)
    {
        $this->adminDlvrService = $adminDlvrService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->adminDlvrService->findAdminDeliveries();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AdminDeliveryStoreRequest $request)
    {
        return $this->adminDlvrService->createAdminDlvr($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $adminDlvrId)
    {
        return $this->adminDlvrService->findAdminDlvrById($adminDlvrId);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AdminDeliveryUpdateRequest $request, int $adminDlvrId)
    {
        return $this->adminDlvrService->updateAdminDlvr($request, $adminDlvrId);
    }
}
