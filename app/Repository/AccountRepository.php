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
        return Account::findOrFail($accountId);
    }

    public function create(object $payload) 
    {
        $account = new Account();
        $account->username = $payload->username;
        $account->email = $payload->email;
        $account->password = $payload->password;
        $accountType = AccountType::find($payload->accTypeID);
        
        if ($accountType) {
            $account->accountType()->associate($accountType);
        } else {
            // Handle the error: throw an exception, return an error response, or set a default value
            throw new \Exception("Invalid account type ID provided.");
        }

        $account->save();

        return $account->fresh();
    }

    public function update(object $payload, int $accountId)
    {
        $account = Account::findOrFail($accountId);
        $account->username = $payload->username;
        $account->email = $payload->email;
        $account->password = $payload->password;
        $accountType = AccountType::find($payload->accTypeID);

        if ($accountType) {
            $account->accountType()->associate($accountType);
        } else {
            // Handle the error: throw an exception, return an error response, or set a default value
            throw new \Exception("Invalid account type ID provided.");
        }

        $account->save();

        return $account->fresh();
    }

    public function delete(int $accountId)
    {
        $account = Account::findOrFail($accountId);
        $account->delete();

        return response()->json([
            'message' => 'Successfully Deleted'
        ], Response::HTTP_OK);
    }
}