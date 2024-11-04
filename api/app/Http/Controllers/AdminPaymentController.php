<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminPaymentStoreRequest;
use App\Http\Requests\AdminPaymentUpdateRequest;
use App\Interface\Service\AdminPaymentServiceInterface;

class AdminPaymentController extends Controller
{
    private $adminPaymentService;

    public function __construct(AdminPaymentServiceInterface $adminPaymentService)
    {
        $this->adminPaymentService = $adminPaymentService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->adminPaymentService->findAdminPayments();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AdminPaymentStoreRequest $request)
    {
        return $this->adminPaymentService->createAdminPayment($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $adminOrderId)
    {
        return $this->adminPaymentService->findAdminPaymentById($adminOrderId);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AdminPaymentUpdateRequest $request, int $adminPaymentId)
    {
        return $this->adminPaymentService->updateAdminPayment($request, $adminPaymentId);
    }
}
