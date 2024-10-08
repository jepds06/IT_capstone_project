<?php

namespace App\Http\Controllers;

use App\Http\Requests\FinishedProductStoreRequest;
use App\Http\Requests\FinishedProducUpdateRequest;
use App\Interface\Service\FinishedProductServiceInterface;
use Illuminate\Http\Request;

class FinishedProductController extends Controller
{
    private $fnshProdService;

    public function __construct(FinishedProductServiceInterface $fnshProdService)
    {
        $this->fnshProdService = $fnshProdService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->fnshProdService->findFinishedProducts();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FinishedProductStoreRequest $request)
    {
        return $this->fnshProdService->createFinishedProduct($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $fnshProductId)
    {
        return $this->fnshProdService->findFinishedProductById($fnshProductId);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FinishedProducUpdateRequest $request, int $fnshProductId)
    {
        return $this->fnshProdService->updateFinishedProduct($request, $fnshProductId);
    }
}
