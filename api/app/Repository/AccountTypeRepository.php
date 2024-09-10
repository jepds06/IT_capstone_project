<?php

namespace App\Repository;

use App\Interface\Repository\AccountTypeRepositoryInterface;
use App\Models\AccountType;
use Illuminate\Http\Response;

class AccountTypeRepository implements AccountTypeRepositoryInterface
{
    public function findMany()
    {
        return AccountType::paginate(10);
    }

    public function findOnebyId(int $accTypeId)
    {
        return AccountType::FindorFail($accTypeId);
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
        $accountType = AccountType::FindorFail($accountTypeId);
        $accountType->account_type_name = $payload->account_type_name;
        $accountType->save();

        return $accountType->fresh();
    }
}