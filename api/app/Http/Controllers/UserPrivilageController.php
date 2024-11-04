<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserPrivilageStoreRequest;
use App\Http\Requests\UserPrivilageUpdateRequest;
use App\Interface\Service\UserPrivilageServiceInterface;

class UserPrivilageController extends Controller
{
    private $userPrivilageService;

    public function __construct(UserPrivilageServiceInterface $userPrivilageService)
    {
        $this->userPrivilageService = $userPrivilageService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->userPrivilageService->findUserPrivilage();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserPrivilageStoreRequest $request)
    {
        return $this->userPrivilageService->createUserPrivilage($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $userPrivilageId)
    {
        return $this->userPrivilageService->findUserPrivilageById($userPrivilageId);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserPrivilageUpdateRequest $request, int $userPrivilageId)
    {
        return $this->userPrivilageService->updateUserPrivilage($request, $userPrivilageId);
    }
}
