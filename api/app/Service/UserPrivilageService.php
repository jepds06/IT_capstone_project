<?php

namespace App\Service;

use App\Http\Resources\UserPrivilageResource;
use App\Interface\Repository\UserPrivilageRepositoryInterface;
use App\Interface\Service\UserPrivilageServiceInterface;

class UserPrivilageService implements UserPrivilageServiceInterface
{
    private $userPrivilageRepository;

    public function __construct(UserPrivilageRepositoryInterface $userPrivilageRepository)
    {
        $this->userPrivilageRepository = $userPrivilageRepository;
    }

    public function findUserPrivilage()
    {
        $userTypes = $this->userPrivilageRepository->findMany();

        return UserPrivilageResource::collection($userTypes);
    }

    public function findUserPrivilageById(int $userTypeId)
    {
        $userType = $this->userPrivilageRepository->findOneById($userTypeId);

        return new UserPrivilageResource($userType);
    }

    public function createUserPrivilage(object $payload)
    {
        $userType = $this->userPrivilageRepository->create($payload);

        return new UserPrivilageResource($userType);
    }

    public function updateUserPrivilage(object $payload, int $userTypeId)
    {
        $userType = $this->userPrivilageRepository->update($payload, $userTypeId);

        return new UserPrivilageResource($userType);
    }
}