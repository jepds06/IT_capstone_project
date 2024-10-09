<?php

namespace App\Interface\Repository;

interface QuotationDetailRepositoryInterface
{
    public function findMany();

    public function findOneById(int $qteDetailId);

    public function create(object $payload);

    public function update(object $payload, int $qteDetailId);
}