<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserAuthRequest;
use App\Interface\Service\UserAuthServiceInterface;
use Illuminate\Http\Request;

class UserAuthController extends Controller
{
    private $userAuthService;

    public function __construct(UserAuthServiceInterface $userAuthService)
    {
        $this->userAuthService = $userAuthService;
    }

    public function login(UserAuthRequest $request)
    {
        return $this->userAuthService->authenticate($request);
    }

    public function logout(Request $request)
    {
        return $this->userAuthService->unauthenticate($request);
    }
}
