<?php

namespace App\Repository;

use App\Interface\Repository\SupplierRepositoryInterface;
use App\Models\Account;
use App\Models\Supplier;
use Illuminate\Http\Response;

class SupplierRepository implements SupplierRepositoryInterface
{
    public function findMany()
    {
        return Supplier::paginate(10);
    }

    public function findOneById(int $supplierId)
    {
        return Supplier::findOrFail($supplierId);
    }

    public function create(object $payload)
    {
        $supplier = new Supplier();
        $account = Account::find($payload->account_ID);
        if ($account) {
            $supplier->account()->associate($account);
        } else {
            // Handle the error: throw an exception, return an error response, or set a default value
            throw new \Exception("Invalid account ID provided.");
        }
        $supplier->supplier_name = $payload->supplier_name;
        $supplier->supplier_address = $payload->supplier_address;
        $supplier->supplier_email = $payload->supplier_email;
        $supplier->supplier_contact_num = $payload->supplier_contact_num;
        $supplier->supplier_type = $payload->supplier_type;
        $supplier->supplier_status = $payload->supplier_status;

        $supplier->save();

        return $supplier->fresh();
    }

    public function update(object $payload, int $supplierId)
    {
        $supplier = Supplier::findOrFail($supplierId);
        $account = Account::find($payload->account_ID);
        if ($account) {
            $supplier->account()->associate($account);
        } else {
            // Handle the error: throw an exception, return an error response, or set a default value
            throw new \Exception("Invalid account ID provided.");
        }
        $supplier->supplier_name = $payload->supplier_name;
        $supplier->supplier_address = $payload->supplier_address;
        $supplier->supplier_email = $payload->supplier_email;
        $supplier->supplier_contact_num = $payload->supplier_contact_num;
        $supplier->supplier_type = $payload->supplier_type;
        $supplier->supplier_status = $payload->supplier_status;

        $supplier->save();

        return $supplier->fresh();
    }

    public function delete(int $supplierId)
    {
        $supplier = Supplier::findOrFail($supplierId);
        $supplier->delete();

        return response()->json([
            'message' => 'Successfully Deleted'
        ], Response::HTTP_OK);
    }
}