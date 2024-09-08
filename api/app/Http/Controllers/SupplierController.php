<?php

namespace App\Http\Controllers;

use App\Http\Requests\SupplierStoreRequest;
use App\Http\Requests\SupplierUpdateRequest;
use App\Interface\Service\SupplierServiceInterface;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    private $supplierService;

    public function __construct(SupplierServiceInterface $supplierService)
    {
        $this->supplierService = $supplierService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->supplierService->findSuppliers();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SupplierStoreRequest $request)
    {
        return $this->supplierService->createSupplier($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $supplierId)
    {
        return $this->supplierService->findSupplierById($supplierId);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SupplierUpdateRequest $request, int $supplierId)
    {
        return $this->supplierService->updateSupplier($request, $supplierId);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $supplierId)
    {
        return $this->supplierService->deleteSupplier($supplierId);
    }
}
