<?php

namespace App\Interface\Service;

interface AccountServiceInterface
{
    public function findAccounts();

    public function findAccountById(int $accountId);

    public function createAccount(object $payload);

    public function updateAccount(object $payload, int $accountId);

    public function deleteAccount(int $accountId);
}