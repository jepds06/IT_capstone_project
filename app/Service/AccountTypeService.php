<?php

namespace App\Service;

use App\Interface\Service\AccountServiceInterface;
use App\Http\Resources\AccountTypeResource;

class AccountTypeService implements AccountTypeServiceInterface
{
    private $accountTypeRepository;

    public function __construct(AccountTypeRepositoryInterface $accountTypeRepository)
    {
        $this->accountRepository = $accountRepository;
    }

    public function findAccountTypes()
    {
        $accountTypes = $this->accountTypeRepository->findMany();

        return AccountTypeResource::collection($accountTypes);
    }

    public function findAccountTypeById(int $accountTypeRepository)
    {
        $accountType = $this->accountTypeRepository->findOneById($accountTypeId);

        return new AccountTypeResource($accountTypeId);
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