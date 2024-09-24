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
        $account = Account::find($payload->accountID);
        if ($account) {
            $customer->account()->associate($account);
        } else {
            // Handle the error: throw an exception, return an error response, or set a default value
            throw new \Exception("Invalid account ID provided.");
        }
        $customer->cstrFirstName = $payload->cstrFirstName;
        $customer->cstrLastName = $payload->cstrLastName;
        $customer->contactNum = $payload->contactNum;
        $customer->cstrAddress = $payload->cstrAddress;
        $customer->customerType = $payload->customerType;
        $customer->prefContactMethod = $payload->prefContactMethod;
        $customer->cstrStatus = $payload->cstrStatus;

        $customer->save();

        return $customer->fresh();
    }

    public function update(object $payload, int $cstrId)
    {
        $customer = Customer::findOrFail($cstrId);
        $account = Account::find($payload->accountID);
        if ($account) {
            $customer->account()->associate($account);
        } else {
            // Handle the error: throw an exception, return an error response, or set a default value
            throw new \Exception("Invalid account ID provided.");
        }
        $customer->cstrFirstName = $payload->cstrFirstName;
        $customer->cstrLastName = $payload->cstrLastName;
        $customer->contactNum = $payload->contactNum;
        $customer->cstrAddress = $payload->cstrAddress;
        $customer->customerType = $payload->customerType;
        $customer->prefContactMethod = $payload->prefContactMethod;
        $customer->cstrStatus = $payload->cstrStatus;

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