<?php

namespace App\Service;

use App\Interface\Service\AccountServiceInterface;
use App\Interface\Repository\AccountRepositoryInterface;
use App\Http\Resources\AccountResource;

class AccountService implements AccountServiceInterface
{
    private $accountRepository;

    public function __construct(AccountRepositoryInterface $accountRepository)
    {
        $this->accountRepository = $accountRepository;
    }

    public function findAccounts()
    {
        $accounts = $this->accountRepository->findMany();

        return AccountResource::collection($accounts);
    }

    public function findAccountById(int $accountId)
    {
        $account = $this->accountRepository->findOneById($accountId);

        return new AccountResource($account);
    }
    
    public function createAccount(object $payload)
    {
        $account = $this->accountRepository->create($payload);

        return new AccountResource($account);
    }

    public function updateAccount(object $payload, int $accountId)
    {
        $account = $this->accountRepository->update($payload, $accountId);

        return new AccountResource($account);
    }

    public function deleteAccount(int $accountId)
    {
        return $this->accountRepository->delete($accountId);
    }
}