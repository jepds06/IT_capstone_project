<?php

namespace App\Repository;

use App\Interface\Repository\AdminDeliveryRepositoryInterface;
use App\Models\AdminDelivery;
use App\Models\AdminOrder;
use Exception;
use Illuminate\Support\Facades\DB;

class AdminDeliveryRepository implements AdminDeliveryRepositoryInterface
{
    public function findMany()
    {
        return AdminDelivery::with(['adminOrder', 'adminOrder.quotation', 'adminOrder.adminOrderDetail'])->orderBy('deliveryDate', 'desc')->paginate(10);
    }

    public function findOneById(int $adminDlvrId)
    {
        return AdminDelivery::findOrFail($adminDlvrId);
    }

    public function create(object $payload)
    {
        return DB::transaction(function () use ($payload) {
            $adminDlvry = new AdminDelivery();

            $adminOrder = AdminOrder::find($payload->adminOrdID);

            if($adminOrder){
                $adminDlvry->adminOrder()->associate($adminOrder);
            } else {
                throw new \Exception("Invalid admin order ID provided.");
            }

            $adminDlvry->deliveryDate = $payload->deliveryDate;
            $adminDlvry->deliveryStatus = $payload->deliveryStatus;
            $adminDlvry->qtyReceived = $payload->qtyReceived;

            $adminDlvry->save();
            return $adminDlvry->fresh();
        });
    }

    public function update(object $payload, int $adminDlvrId)
    {
        return DB::transaction(function () use ($payload, $adminDlvrId) {
            $adminDlvry = AdminDelivery::findOrFail($adminDlvrId);

            $adminOrder = AdminOrder::find($payload->adminOrdID);

            if($adminOrder){
                $adminDlvry->adminOrder()->associate($adminOrder);
            } else {
                throw new \Exception("Invalid admin order ID provided.");
            }

            $adminDlvry->deliveryDate = $payload->deliveryDate;
            $adminDlvry->deliveryStatus = $payload->deliveryStatus;
            $adminDlvry->qtyReceived = $payload->qtyReceived;

            $adminDlvry->save();
            return $adminDlvry->fresh();
        });
    }
}