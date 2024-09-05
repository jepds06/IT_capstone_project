<?php

namespace App\Repository;

use App\Interface\Repository\CustomerRepositoryInterface;
use App\Models\Account;
use App\Models\Customer;
use Illuminate\Http\Response;

class CustomerRepository implements CustomerRepositoryInterface
{
    public function findMany()
    {
        return Customer::paginate(10);
    }

    public function findOneById(int $cstrId)
    {
        return Customer::findOrFail($cstrId);
    }

    public function create(object $payload)
    {
        $customer = new Customer();
        $account = Account::find($payload->account_ID);
        if ($account) {
            $customer->account()->associate($account);
        } else {
            // Handle the error: throw an exception, return an error response, or set a default value
            throw new \Exception("Invalid account ID provided.");
        }
        $customer->cstr_first_name = $payload->cstr_first_name;
        $customer->cstr_last_name = $payload->cstr_last_name;
        $customer->contact_num = $payload->contact_num;
        $customer->cstr_address = $payload->cstr_address;
        $customer->customer_type = $payload->customer_type;
        $customer->pref_contact_method = $payload->pref_contact_method;
        $customer->cstr_status = $payload->cstr_status;

        $customer->save();

        return $account->fresh();
    }

    public function update(object $payload, int $cstrId)
    {
        $customer = Customer::findOrFail($cstrId);
        $account = Account::find($payload->account_ID);
        if ($account) {
            $customer->account()->associate($account);
        } else {
            // Handle the error: throw an exception, return an error response, or set a default value
            throw new \Exception("Invalid account ID provided.");
        }
        $customer->cstr_first_name = $payload->cstr_first_name;
        $customer->cstr_last_name = $payload->cstr_last_name;
        $customer->contact_num = $payload->contact_num;
        $customer->cstr_address = $payload->cstr_address;
        $customer->customer_type = $payload->customer_type;
        $customer->pref_contact_method = $payload->pref_contact_method;
        $customer->cstr_status = $payload->cstr_status;

        $customer->save();

        return $account->fresh();
    }

    public function delete(int $cstrId)
    {
        $customer = Customer::findOrFail($cstrId);
        $customer->delete();

        return response()->json([
            'message' => 'Successfully Deleted'
        ], Response::HTTP_OK);
    }
}