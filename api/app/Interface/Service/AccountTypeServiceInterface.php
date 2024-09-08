<?php

namespace App\Interface\Service;

interface AccountTypeServiceInterface
{
    public function findAccountTypes();

    public function findAccountTypeById(int $accountTypeId);

    public function createAccountType(object $payload);

    public function updateAccountType(object $payload, int $accountTypeId);
}