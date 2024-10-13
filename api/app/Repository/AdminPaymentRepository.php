<?php

namespace App\Repository;

use App\Interface\Repository\AdminOrderRepositoryInterface;
use App\Models\AdminOrder;
use App\Models\AdminPayment;
use App\Models\PaymentMethod;

class AdminPaymentRepository implements AdminOrderRepositoryInterface
{
    public function findMany()
    {
        return AdminOrder::paginate(10);
    }

    public function findOneById(int $adminPaymentId)
    {
        return AdminOrder::findOrFail($adminPaymentId);
    }

    public function create(object $payload)
    {
        $adminPayment = new AdminPayment();

        $adminOrder = AdminOrder::find($payload->adminOrderID);

        if($adminOrder){
            $adminPayment->productionDetail()->associate($adminOrder);
        } else {
            throw new \Exception("Invalid production detail ID provided.");
        }

        $paymentMethod = PaymentMethod::find($payload->payMethodID);

        if($paymentMethod){
            $adminPayment->productionDetail()->associate($paymentMethod);
        } else {
            throw new \Exception("Invalid production detail ID provided.");
        }

        $adminPayment->adminOrderID = $payload->adminOrderID;
        $adminPayment->payMethodID = $payload->payMethodID; 
        $adminPayment->amountToPay = $payload->amountToPay; 
        $adminPayment->amountPaid = $payload->amountPaid;
        $adminPayment->dueDate = $payload->dueDate;
        $adminPayment->paymentStatus = $payload->paymentStatus;
        $adminPayment->remarks = $payload->remarks;


        $adminPayment->save();

        return $adminPayment->fresh();
    }

    
    public function update(object $payload, int $adminPaymentId)
    {
        $adminPayment = new AdminPayment();

        $adminOrder = AdminOrder::find($payload->adminOrderID);

        if($adminOrder){
            $adminPayment->productionDetail()->associate($adminOrder);
        } else {
            throw new \Exception("Invalid production detail ID provided.");
        }

        $paymentMethod = PaymentMethod::find($payload->payMethodID);

        if($paymentMethod){
            $adminPayment->productionDetail()->associate($paymentMethod);
        } else {
            throw new \Exception("Invalid production detail ID provided.");
        }

        $adminPayment->adminOrderID = $payload->adminOrderID;
        $adminPayment->payMethodID = $payload->payMethodID; 
        $adminPayment->amountToPay = $payload->amountToPay; 
        $adminPayment->amountPaid = $payload->amountPaid;
        $adminPayment->dueDate = $payload->dueDate;
        $adminPayment->paymentStatus = $payload->paymentStatus;
        $adminPayment->remarks = $payload->remarks;


        $adminPayment->save();

        return $adminPayment->fresh();
    }
}