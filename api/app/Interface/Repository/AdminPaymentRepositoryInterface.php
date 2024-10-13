<?php

namespace App\Interface\Repository;

interface AdminPaymentRepositoryInterface
{
    public function findMany();

    public function findOneById(int $adminPaymentId);

    public function create(object $payload);

    public function update(object $payload, int $adminPaymentId);
}