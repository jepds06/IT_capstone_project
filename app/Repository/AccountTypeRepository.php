<?php

namespace App\Repository;

use App\Interface\Repository\AccountTypeRepositoryInterface;

class AccountTypeRepository implements AccountTypeRepositoryInterface
{
    public function findMany()
    {
        return AccountTypes::paginate(10);
    }

    public function findOnebyId(int $accTypeId)
    {
        return AccountTypes::FindorFail($accTypeId);
    }

    public function create(object $payload)
    {
        $accountType = new AccountType();
        $accountType->account_type_name = $payload->account_type_name;
        $accountType->save();

        return $accountType->fresh();
    }

    public function update(object $payload, int $accountTypeId)
    {
        $accountType = new AccountType();
        $accountType->account_type_name = $payload->account_type_name;
        $accountType->save();

        return $accountType->fresh();
    }
}