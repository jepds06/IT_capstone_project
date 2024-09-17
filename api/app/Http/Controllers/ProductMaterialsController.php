<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductMaterialsStoreRequest;
use App\Http\Requests\ProductMaterialsUpdateRequest;
use App\Interface\Service\ProductMaterialServiceInterface;
use Illuminate\Http\Request;

class ProductMaterialsController extends Controller
{
    private $productMaterialsService;

    public function __construct(ProductMaterialServiceInterface $productMaterialsService)
    {
        $this->productMaterialsService = $productMaterialsService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->productMaterialsService->findProductMats();
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductMaterialsStoreRequest $request)
    {
        return $this->productMaterialsService->createProductMats($request);
    }

    /**
     * Display the specified resource.
     */
    public function showMaterialsByProductID(int $productID)
    {
        return $this->productMaterialsService->findProdMatsByProductId($productID);
    }

    public function show(int $productMatsId)
    {
        return $this->productMaterialsService->findProductMatsById($productMatsId);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(ProductMaterialsUpdateRequest $request, int $productMatsId)
    {
        return $this->productMaterialsService->updateProductMats($request, $productMatsId);
    }
}
