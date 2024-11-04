<?php

namespace App\Repository;

use App\Interface\Repository\AdminPaymentRepositoryInterface;
use App\Models\AdminOrder;
use App\Models\AdminOrderDetail;
use App\Models\AdminPayment;
use App\Models\PaymentMethod;

class AdminPaymentRepository implements AdminPaymentRepositoryInterface
{
    public function findMany()
    {
        return AdminPayment::paginate(10);
    }

    public function findOneById(int $adminPaymentId)
    {
        return AdminPayment::findOrFail($adminPaymentId);
    }

    public function create(object $payload)
    {
        $adminPayment = new AdminPayment();

        $orderDetail = AdminOrderDetail::find($payload->adminOrdDetailID);

        if ($orderDetail) {
            $adminPayment->adminOrdDetail()->associate($orderDetail);
        } else {
            throw new \Exception("Invalid admin order detail ID provided.");
        }

        $paymentMethod = PaymentMethod::find($payload->payMethodID);

        if($paymentMethod){
            $adminPayment->paymentMethod()->associate($paymentMethod);
        } else {
            throw new \Exception("Invalid payment method ID provided.");
        }

        $adminPayment->paymentDate = $payload->paymentDate;
        $adminPayment->amountToPay = $orderDetail->amount;
        //retrieving admin order details
        if (!$orderDetail) {
            throw new \Exception("Order details not found.");
        }
        $adminPayment->amountPaid = $payload->amountPaid;
        $adminPayment->paymentStatus = $payload->paymentStatus;
        $adminPayment->remarks = $payload->remarks;


        $adminPayment->save();

        return $adminPayment->fresh();
    }

    
    public function update(object $payload, int $adminPaymentId)
    {
        $adminPayment = AdminPayment::findOrFail($adminPaymentId);

        $orderDetail = AdminOrderDetail::find($payload->adminOrdDetailID);

        if ($orderDetail) {
            $adminPayment->adminOrdDetail()->associate($orderDetail);
        } else {
            throw new \Exception("Invalid admin order detail ID provided.");
        }

        $paymentMethod = PaymentMethod::find($payload->payMethodID);

        if($paymentMethod){
            $adminPayment->paymentMethod()->associate($paymentMethod);
        } else {
            throw new \Exception("Invalid payment method ID provided.");
        }

        $adminPayment->paymentDate = $payload->paymentDate;
        $adminPayment->amountToPay = $orderDetail->amount;
        //retrieving admin order details
        if (!$orderDetail) {
            throw new \Exception("Order details not found.");
        } 
        $adminPayment->amountPaid = $payload->amountPaid;
        $adminPayment->paymentStatus = $payload->paymentStatus;
        $adminPayment->remarks = $payload->remarks;


        $adminPayment->save();

        return $adminPayment->fresh();
    }
}