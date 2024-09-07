<?php

namespace App\Http\Controllers;

use App\Interface\Service\AccountTypeServiceInterface;
use App\Http\Requests\AccountTypeStoreRequest;
use App\Http\Requests\AccountTypeUpdateRequest;
use Illuminate\Http\Request;

class AccountTypeController extends Controller
{
    private $accountTypeService;

    public function __construct(AccountTypeServiceInterface $accountTypeService)
    {
        $this->accountTypeService = $accountTypeService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->accountTypeService->findAccountTypes();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AccountTypeStoreRequest $request)
    {
        return $this->accountTypeService->createAccountType($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $accountTypeId)
    {
        return $this->accountTypeService->findAccountTypeById($accountTypeId);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AccountTypeUpdateRequest $request, int $accountTypeId)
    {
        return $this->accountTypeService->updateAccountType($request, $accountTypeId);
    }
}
