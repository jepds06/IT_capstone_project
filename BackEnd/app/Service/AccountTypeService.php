<?php

namespace App\Service;

use App\Interface\Service\AccountTypeServiceInterface;
use App\Interface\Repository\AccountTypeRepositoryInterface;
use App\Http\Resources\AccountTypeResource;

class AccountTypeService implements AccountTypeServiceInterface
{
    private $accountTypeRepository;

    public function __construct(AccountTypeRepositoryInterface $accountTypeRepository)
    {
        $this->accountTypeRepository = $accountTypeRepository;
    }

    public function findAccountTypes()
    {
        $accountTypes = $this->accountTypeRepository->findMany();

        return AccountTypeResource::collection($accountTypes);
    }

    public function findAccountTypeById(int $accountTypeId)
    {
        $accountType = $this->accountTypeRepository->findOneById($accountTypeId);

        return new AccountTypeResource($accountType);
    }

    public function createAccountType(object $payload)
    {
        $accountType = $this->accountTypeRepository->create($payload);

        return new AccountTypeResource($accountType);
    }

    public function updateAccountType(object $payload, int $accountTypeId)
    {
        $accountType = $this->accountTypeRepository->update($payload, $accountTypeId);

        return new AccountTypeResource($accountType);
    }
}