<?php

namespace App\Interface\Repository;

interface AdminDeliveryRepositoryInterface
{
    public function findMany();

    public function findOneById(int $adminDlvrId);

    public function create(object $payload);

    public function update(object $payload, int $adminDlvrId);
}