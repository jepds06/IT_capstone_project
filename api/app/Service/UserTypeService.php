<?php

namespace App\Service;

use App\Http\Resources\UserTypeResource;
use App\Interface\Repository\UserTypeRepositoryInterface;
use App\Interface\Service\UserTypeServiceInterface;

class UserTypeService implements UserTypeServiceInterface
{
    private $userTypeRepository;

    public function __construct(UserTypeRepositoryInterface $userTypeRepository)
    {
        $this->userTypeRepository = $userTypeRepository;
    }

    public function findUserTypes()
    {
        $userTypes = $this->userTypeRepository->findMany();

        return UserTypeResource::collection($userTypes);
    }

    public function findUserTypeById(int $userTypeId)
    {
        $userType = $this->userTypeRepository->findOneById($userTypeId);

        return new UserTypeResource($userType);
    }

    public function createUserType(object $payload)
    {
        $userType = $this->userTypeRepository->create($payload);

        return new UserTypeResource($userType);
    }

    public function updateUserType(object $payload, int $userTypeId)
    {
        $userType = $this->userTypeRepository->update($payload, $userTypeId);

        return new UserTypeResource($userType);
    }
}