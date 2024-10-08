<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuotationStoreRequest;
use App\Http\Requests\QuotationUpdateRequest;
use App\Interface\Service\QuotationServiceInterface;
use Illuminate\Http\Request;

class QuotationController extends Controller
{
    private $quotationService;

    public function __construct(QuotationServiceInterface $quotationService)
    {
        $this->quotationService = $quotationService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->quotationService->findQuotations();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(QuotationStoreRequest $request)
    {
        return $this->quotationService->createQuotation($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $quoteId)
    {
        return $this->quotationService->findQuotationById($quoteId);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(QuotationUpdateRequest $request, int $quoteId)
    {
        return $this->quotationService->updateQuotation($request, $quoteId);
    }
}
