<?php

namespace App\Repository;

use App\Interface\Repository\AccountRepositoryInterface;
use App\Models\Account;
use App\Models\AccountType;
use Illuminate\Http\Response;

class AccountRepository implements AccountRepositoryInterface
{
    public function findMany ()
    {
        return Account::paginate(10);
    }

    public function findOneById (int $accountId)
    {
        return Account::FindorFail($accountId);
    }

    public function create(object $payload) 
    {
        $account = new Account();
        $account->username = $payload->username;
        $account->email = $payload->email;
        $account->password = $payload->password;
        $accountType = AccountType::find($payload->acc_type_ID);
        $account->accountType()->associate($payload->$accountType);

        $account->save();

        return $account->fresh();
    }

    public function update(object $payload, int $accountId)
    {
        $account = Account::FindorFail($accountId);
        $account->username = $payload->username;
        $account->email = $payload->email;
        $account->password = $payload->password;
        $accountType = AccountType::find($payload->acc_type_ID);
        $account->accountType()->associate($payload->$accountType);

        $account->save();

        return $account->fresh();
    }

    public function delete(int $account_ID)
    {
        $account = Account::findorFail($accountId);
        $account = delete();

        return response()->json([
            'message' => 'Successfully Deleted'
        ], Response::HTTP_OK);
    }
}