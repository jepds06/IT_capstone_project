<?php

namespace App\Repository;

use App\Interface\Repository\CustomerPaymentRepositoryInterface;
use App\Models\CustomerPayment;
use App\Models\PaymentMethod;
use App\Models\SalesProductOrder;

class CustomerPaymentRepository implements CustomerPaymentRepositoryInterface
{
    public function findMany()
    {
        return CustomerPayment::paginate(10);
    }

    public function findOneById(int $cstrPayId)
    {
        return CustomerPayment::findOrFail($cstrPayId);
    }

    public function create(object $payload)
    {
        $cstrPay = new CustomerPayment();

        $slsPrdOrder = SalesProductOrder::find($payload->slsPrdOrdID);
        if($slsPrdOrder){
            $cstrPay->slsPrdOrder()->associate($slsPrdOrder);
        } else {
            throw new \Exception("Invalid sales product order ID provided.");
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

        $slsPrdOrder = SalesProductOrder::find($payload->slsPrdOrdID);
        if($slsPrdOrder){
            $cstrPay->slsPrdOrder()->associate($slsPrdOrder);
        } else {
            throw new \Exception("Invalid sales product order ID provided.");
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