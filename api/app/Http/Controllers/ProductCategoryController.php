<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductCategoryStoreRequest;
use App\Http\Requests\ProductCategoryUpdateRequest;
use App\Interface\Service\ProductCategoryServiceInterface;
use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{
    private $prodCatService;

    public function __construct(ProductCategoryServiceInterface $prodCatService)
    {
        $this->prodCatService = $prodCatService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->prodCatService->findProductCategory();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductCategoryStoreRequest $request)
    {
        return $this->prodCatService->createProductCategory($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $prodCatId)
    {
        return $this->prodCatService->findProdCatById($prodCatId);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductCategoryUpdateRequest $request, int $prodCatId)
    {
        return $this->prodCatService->updateProductCategory($request, $prodCatId);
    }

}
