<?php

namespace App\Interface\Repository;

interface CustomerPaymentRepositoryInterface
{
    public function findMany();

    public function findOneById(int $cstrPayId);

    public function create(object $payload);

    public function update(object $payload, int $cstrPayId);
}