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
        return Administrator::FindorFail($adminId);
    }

    public function create(object $payload)
    {
        $admin = new Administrator();
        $account = Account::find($payload->account_ID);
        $admin->account()->associate($payload->account);
        $admin->admin_first_name = $payload->admin_first_name;
        $admin->admin_last_name = $payload->admin_last_name;
        $admin->contact_num = $payload->contact_num;
        $admin->admin_address = $payload->admin_address;

        $admin->save();

        return $admin->fresh();
    }

    public function update(object $payload, int $adminId)
    {
        $admin = Administrator::FindorFail($adminId);
        $account = Account::find($payload->account_ID);
        $admin->account()->associate($payload->account);
        $admin->admin_first_name = $payload->admin_first_name;
        $admin->admin_last_name = $payload->admin_last_name;
        $admin->contact_num = $payload->contact_num;
        $admin->admin_address = $payload->admin_address;

        $admin->save();

        return $admin->fresh();
    }

    public function delete(int $adminId)
    {
        $admin = Administrator::findorFail($adminId);
        $admin->delete();

        return response()->json([
            'message' => 'Successfully Deleted'
        ], Response::HTTP_OK);
    }
}

