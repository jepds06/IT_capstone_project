<?php

namespace App\Http\Controllers;

use App\Http\Requests\SupplierMaterialStoreRequest;
use App\Http\Requests\SupplierMaterialUpdateRequest;
use App\Interface\Service\SupplierMaterialServiceInterface;
use Illuminate\Http\Request;

class SupplierMaterialController extends Controller
{
    private $suppMaterialService;

    public function __construct(SupplierMaterialServiceInterface $suppMaterialService)
    {
        $this->suppMaterialService = $suppMaterialService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->suppMaterialService->findSupplierMaterials();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SupplierMaterialStoreRequest $request)
    {
        return $this->suppMaterialService->createSupplierMaterial($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $suppMtrlId)
    {
        return $this->suppMaterialService->findSupplierMaterialById($suppMtrlId);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SupplierMaterialUpdateRequest $request, int $suppMtrlId)
    {
        return $this->suppMaterialService->updateSupplierMaterial($request, $suppMtrlId);
    }
}
