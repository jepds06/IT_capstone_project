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
        $accountType->accountTypeName = $payload->accountTypeName;
        $accountType->save();

        return $accountType->fresh();
    }

    public function update(object $payload, int $accountTypeId)
    {
        $accountType = AccountType::findOrFail($accountTypeId);
        $accountType->accountTypeName = $payload->accountTypeName;
        $accountType->save();

        return $accountType->fresh();
    }
}