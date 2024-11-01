<?php

namespace App\Service;

use App\Http\Resources\UserAuthResource;
use App\Http\Resources\UserResource;
use App\Interface\Repository\UserAuthRepositoryInterface;
use App\Interface\Service\UserAuthServiceInterface;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class UserAuthService implements UserAuthServiceInterface
{
    private $userAuthRepository;

    public function __construct(UserAuthRepositoryInterface $userAuthRepository)
    {
        $this->userAuthRepository = $userAuthRepository;
    }

    public function authenticate(object $payload)
    {
        $userAuth = $this->userAuthRepository->findByEmail($payload->email);

        if (!$userAuth) {
            return response()->json([
                'message' => 'No account found'
            ], Response::HTTP_UNAUTHORIZED);
        }

        if (!Hash::check($payload->password, $userAuth->password)) {
            return response()->json([
                'message' => 'Invalid Credentials'
            ], Response::HTTP_UNAUTHORIZED);
        }

        $token = $userAuth->createToken('auth-token')->plainTextToken;

        $data = (object) [
            'token' => $token,
            'user' => new UserResource($userAuth)
        ];

        return new UserAuthResource($data);
    }

    public function unauthenticate(object $payload)
    {
        $payload->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Successfully Logged out'
        ], Response::HTTP_OK);
    }
}