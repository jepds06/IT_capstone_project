<?php

namespace App\Repository;

use App\Interface\Repository\PaymentMethodRepositoryInterface;
use App\Models\PaymentMethod;

class PaymentMethodRepository implements PaymentMethodRepositoryInterface
{
    public function findMany()
    {
        return PaymentMethod::paginate(10);
    }

    public function findOneById(int $payMethodId)
    {
        return PaymentMethod::findOrFail($payMethodId);
    }

    public function create(object $payload)
    {
        $payMethod = new PaymentMethod();

        $payMethod->payMethodName = $payload->payMethodName;

        $payMethod->save();
        return $payMethod->fresh();
    }

    public function update(object $payload, int $payMethodId)
    {
        $payMethod = PaymentMethod::findOrFail($payMethodId);

        $payMethod->payMethodName = $payload->payMethodName;

        $payMethod->save();
        return $payMethod->fresh();
    }
}