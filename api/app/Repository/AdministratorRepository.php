<?php

namespace App\Repository;

use App\Interface\Repository\AdministratorRepositoryInterface;
use App\Models\Administrator;
use App\Models\Account;
use Illuminate\Http\Response;

class AdministratorRepository implements AdministratorRepositoryInterface
{
    public function findMany()
    {
        return Administrator::paginate(10);
    }

    public function findOnebyId(int $adminId)
    {
        return Administrator::findOrFail($adminId);
    }

    public function create(object $payload)
    {
        $admin = new Administrator();
        $account = Account::find($payload->account_ID);
        if ($account) {
            $admin->accountType()->associate($account);
        } else {
            // Handle the error: throw an exception, return an error response, or set a default value
            throw new \Exception("Invalid account ID provided.");
        }
        $admin->admin_first_name = $payload->admin_first_name;
        $admin->admin_last_name = $payload->admin_last_name;
        $admin->contact_num = $payload->contact_num;
        $admin->admin_address = $payload->admin_address;

        $admin->save();

        return $admin->fresh();
    }

    public function update(object $payload, int $adminId)
    {
        $admin = Administrator::findOrFail($adminId);
        $account = Account::find($payload->account_ID);
        if ($account) {
            $admin->account()->associate($account);
        } else {
            // Handle the error: throw an exception, return an error response, or set a default value
            throw new \Exception("Invalid account ID provided.");
        }
        $admin->admin_first_name = $payload->admin_first_name;
        $admin->admin_last_name = $payload->admin_last_name;
        $admin->contact_num = $payload->contact_num;
        $admin->admin_address = $payload->admin_address;

        $admin->save();

        return $admin->fresh();
    }

    public function delete(int $adminId)
    {
        $admin = Administrator::findOrFail($adminId);
        $admin->delete();

        return response()->json([
            'message' => 'Successfully Deleted'
        ], Response::HTTP_OK);
    }
}

