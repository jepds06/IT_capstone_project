<?php

namespace App\Interface\Repository;

interface PaymentMethodRepositoryInterface
{
    public function findMany();

    public function findOneById(int $payMethodId);

    public function create(object $payload);

    public function update(object $payload, int $payMethodId);
}