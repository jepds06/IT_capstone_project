<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerPaymentStoreRequest;
use App\Http\Requests\CustomerPaymentUpdateRequest;
use App\Interface\Service\CustomerPaymentServiceInterface;
use Illuminate\Http\Request;

class CustomerPaymentController extends Controller
{
    private $cstrPayService;

    public function __construct(CustomerPaymentServiceInterface $cstrPayService)
    {
        $this->cstrPayService = $cstrPayService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->cstrPayService->findCustomerPayments();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CustomerPaymentStoreRequest $request)
    {
        return $this->cstrPayService->createCustomerPayment($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $cstrPayId)
    {
        return $this->cstrPayService->findCustomerPaymentById($cstrPayId);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CustomerPaymentUpdateRequest $request, int $cstrPayId)
    {
        return $this->cstrPayService->updateCustomerPayment($request, $cstrPayId);
    }
}
