<?php

namespace App\Service;

use App\Http\Resources\UserResource;
use App\Interface\Repository\UserRegRepositoryInterface;
use App\Interface\Service\UserRegServiceInterface;

class UserRegService implements UserRegServiceInterface
{
    private $userRegRepository;

    public function __construct(UserRegRepositoryInterface $userRegRepository)
    {
        $this->userRegRepository = $userRegRepository;
    }

    public function findUsers()
    {
        $users = $this->userRegRepository->findMany();

        return UserResource::collection($users);
    }

    public function findUserById(int $userId)
    {
        $user = $this->userRegRepository->findOneById($userId);

        return new UserResource($user);
    }

    public function createUser(object $payload)
    {
        $user = $this->userRegRepository->create($payload);

        return new UserResource($user);
    }

    public function updateUser(object $payload, int $userId)
    {
        $user = $this->userRegRepository->update($payload, $userId);

        return new UserResource($user);
    }
}