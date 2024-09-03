<?php

namespace App\Http\Controllers;

use App\Http\Requests\AccountStoreRequest;
use App\Http\Requests\AccountUpdateRequest;
use App\Interface\Service\AccountServiceInterface;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    private $accountService;

    public function __construct(AccountServiceInterface $accountService)
    {
        $this->accountService = $accountService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->accountService->findAccounts();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AccountStoreRequest $request)
    {
        return $this->accountService->createAccount($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $accountId)
    {
        return $this->accountService->findAccountByID($accountId);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AccountUpdateRequest $request, int $accountId)
    {
        return $this->accountService->updateAccount($request, $accountId);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $accountId)
    {
        return $this->accountService->deleteAccount($accountId);
    }
}
