<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuotationDetailStoreRequest;
use App\Http\Requests\QuotationDetailUpdateRequest;
use App\Interface\Service\QuotationDetailServiceInterface;
use Illuminate\Http\Request;

class QuotationDetailController extends Controller
{
    private $quoteDetailService;

    public function __construct(QuotationDetailServiceInterface $quoteDetailService)
    {
        $this->quoteDetailService = $quoteDetailService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->quoteDetailService->findQuotationDetails();
    }

     /**
     * Display a listing of the resource.
     */
    public function indexByQuotedID($quoteID)
    {
        return $this->quoteDetailService->findQuotationDetailsByQuoteID($quoteID);
    }


    public function indexAll()
    {
        return $this->quoteDetailService->findQuotationDetailsListQuotations();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(QuotationDetailStoreRequest $request)
    {
        return $this->quoteDetailService->createQuotationDetail($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $qteDetailId)
    {
        return $this->quoteDetailService->findQuotationDetailById($qteDetailId);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(QuotationDetailUpdateRequest $request, int $qteDetailId)
    {
        return $this->quoteDetailService->updateQuotationDetail($request, $qteDetailId);
    }

       /**
     * Delete the specified resource in storage.
     */
    public function delete(int $qteDetailId)
    {
        return $this->quoteDetailService->deleteQuotationDetail($qteDetailId);
    }
}
