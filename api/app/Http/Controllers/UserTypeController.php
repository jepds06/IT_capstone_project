<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserTypeStoreRequest;
use App\Http\Requests\UserTypeUpdateRequest;
use App\Interface\Service\UserTypeServiceInterface;
use Illuminate\Http\Request;

class UserTypeController extends Controller
{
    private $userTypeService;

    public function __construct(UserTypeServiceInterface $userTypeService)
    {
        $this->userTypeService = $userTypeService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->userTypeService->findUserTypes();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserTypeStoreRequest $request)
    {
        return $this->userTypeService->createUserType($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $userTypeId)
    {
        return $this->userTypeService->findUserTypeById($userTypeId);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserTypeUpdateRequest $request, int $userTypeId)
    {
        return $this->userTypeService->updateUserType($request, $userTypeId);
    }
}
