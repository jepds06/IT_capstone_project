<?php

namespace App\Repository;

use App\Interface\Repository\CustomerPaymentRepositoryInterface;
use App\Models\CustomerPayment;
use App\Models\PaymentMethod;
use App\Models\Sale;

class CustomerPaymentRepository implements CustomerPaymentRepositoryInterface
{
    public function findMany()
    {
        return CustomerPayment::with(['sale'])->paginate(10);
    }

    public function findOneById(int $cstrPayId)
    {
        return CustomerPayment::findOrFail($cstrPayId);
    }

    public function create(object $payload)
    {
        $cstrPay = new CustomerPayment();

        $sales = Sale::find($payload->salesID);
        if($sales){
            $cstrPay->sale()->associate($sales);
        } else {
            throw new \Exception("Invalid sales ID provided.");
        }

        $cstrPay->paymentDate = $payload->paymentDate;

        $payMethod = PaymentMethod::find($payload->payMethodID);
        if($payMethod){
            $cstrPay->payMethod()->associate($payMethod);
        } else {
            throw new \Exception("Invalid payment method ID provided.");
        }

        $cstrPay->paymentStatus = $payload->paymentStatus;
        $cstrPay->dueDate = $payload->dueDate;
        $cstrPay->amountToPay = $payload->amountToPay;
        $cstrPay->amountPaid = $payload->amountPaid;

        $cstrPay->save();

        return $cstrPay->fresh();
    }

    public function update(object $payload, int $cstrPayId)
    {
        $cstrPay = CustomerPayment::findOrFail($cstrPayId);

        $sales = Sale::find($payload->salesID);
        if($sales){
            $cstrPay->sale()->associate($sales);
        } else {
            throw new \Exception("Invalid sales ID provided.");
        }

        $cstrPay->paymentDate = $payload->paymentDate;

        $payMethod = PaymentMethod::find($payload->payMethodID);
        if($payMethod){
            $cstrPay->payMethod()->associate($payMethod);
        } else {
            throw new \Exception("Invalid payment method ID provided.");
        }

        $cstrPay->paymentStatus = $payload->paymentStatus;
        $cstrPay->dueDate = $payload->dueDate;
        $cstrPay->amountToPay = $payload->amountToPay;
        $cstrPay->amountPaid = $payload->amountPaid;

        $cstrPay->save();

        return $cstrPay->fresh();
    }
}