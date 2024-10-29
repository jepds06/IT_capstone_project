<?php

namespace App\Repository;

use App\Interface\Repository\AdminOrderRepositoryInterface;
use App\Models\AdminOrder;
use App\Models\QuotationDetail;
use App\Models\SupplierMaterial;
use App\Models\User;

class AdminOrderRepository implements AdminOrderRepositoryInterface
{
    public function findMany()
    {
        return AdminOrder::paginate(10);
    }

    public function findOneById(int $adminOrderId)
    {
        return AdminOrder::findOrFail($adminOrderId);
    }

    public function create(object $payload)
    {
        $adminOrder = new AdminOrder();

        $user = User::find($payload->userID);

        if($user){
            $adminOrder->user()->associate($user);
        } else {
            throw new \Exception("Invalid user ID provided.");
        }

        $qteDetail = QuotationDetail::find($payload->qteDetailID);

        if($qteDetail){
            $adminOrder->quotationDetail()->associate($qteDetail);
        } else {
            throw new \Exception("Invalid quotation detail ID provided.");
        }

        $adminOrder->qtyOrdered = $payload->qtyOrdered; 
        $adminOrder->amount = $payload->amount;

        $adminOrder->save();

        return $adminOrder->fresh();
    }

    
    public function update(object $payload, int $adminOrderId)
    {
        $adminOrder = AdminOrder::findOrFail($adminOrderId);

        $user = User::find($payload->userID);

        if($user){
            $adminOrder->user()->associate($user);
        } else {
            throw new \Exception("Invalid user ID provided.");
        }

        $qteDetail = QuotationDetail::find($payload->qteDetailID);

        if($qteDetail){
            $adminOrder->quotationDetail()->associate($qteDetail);
        } else {
            throw new \Exception("Invalid quotation detail ID provided.");
        }

        $adminOrder->qtyOrdered = $payload->qtyOrdered; 
        $adminOrder->amount = $payload->amount;

        $adminOrder->save();

        return $adminOrder->fresh();
    }
}