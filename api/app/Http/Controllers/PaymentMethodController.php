<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentMethodStoreRequest;
use App\Http\Requests\PaymentMethodUpdateRequest;
use App\Interface\Service\PaymentMethodServiceInterface;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{
    private $payMethodService;

    public function __construct(PaymentMethodServiceInterface $payMethodService)
    {
        $this->payMethodService = $payMethodService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->payMethodService->findPaymentMethods();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PaymentMethodStoreRequest $request)
    {
        return $this->payMethodService->createPaymentMethod($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $payMethodId)
    {
        return $this->payMethodService->findPaymentMethodById($payMethodId);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PaymentMethodUpdateRequest $request, int $payMethodId)
    {
        return $this->payMethodService->updatePaymentMethod($request, $payMethodId);
    }
}
