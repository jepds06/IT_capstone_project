<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRegStoreRequest;
use App\Http\Requests\UserRegUpdateRequest;
use App\Interface\Service\UserRegServiceInterface;
use Illuminate\Http\Request;

class UserRegController extends Controller
{
    private $userRegService;

    public function __construct(UserRegServiceInterface $userRegService)
    {
        $this->userRegService = $userRegService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->userRegService->findUsers();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRegStoreRequest $request)
    {
        return $this->userRegService->createUser($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $userId)
    {
        return $this->userRegService->findUserById($userId);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRegUpdateRequest $request, int $userId)
    {
        return $this->userRegService->updateUser($request, $userId);
    }
}
