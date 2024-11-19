<?php

namespace App\Http\Controllers;

use App\Http\Requests\SalesStoreRequest;
use App\Http\Requests\SalesUpdateRequest;
use App\Interface\Service\SalesServiceInterface;
use Illuminate\Http\Request;

class SalesController extends Controller
{
    private $salesService;

    public function __construct(SalesServiceInterface $salesService)
    {
        $this->salesService = $salesService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->salesService->findSales();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SalesStoreRequest $request)
    {
        return $this->salesService->createSales($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $salesId)
    {
        return $this->salesService->findSaleById($salesId);
    }

     /**
     * Display the specified resource.
     */
    public function showByUserID(int $userID)
    {
        return $this->salesService->findSalesByUserId($userID);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SalesUpdateRequest $request, int $salesId)
    {
        return $this->salesService->updateSales($request, $salesId);
    }
}
