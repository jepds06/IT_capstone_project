<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerStoreRequest;
use App\Http\Requests\CustomerUpdateRequest;
use App\Interface\Service\CustomerServiceInterface;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    private $customerService;

    public function __construct(CustomerServiceInterface $customerService)
    {
        $this->customerService = $customerService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->customerService->findCustomers();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CustomerStoreRequest $request)
    {
        return $this->customerService->createCustomer($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $cstrId)
    {
        return $this->customerService->findCustomerById($cstrId);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CustomerUpdateRequest $request, int $cstrId)
    {
        return $this->customerService->updateCustomer($request, $cstrId);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $cstrId)
    {
        return $this->customerService->deleteCustomer($cstrId);
    }
}
