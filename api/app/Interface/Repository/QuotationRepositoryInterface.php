<?php

namespace App\Interface\Repository;

interface QuotationRepositoryInterface
{
    public function findMany();

    public function findOneById(int $quoteId);

    public function create(object $payload);

    public function update(object $payload, int $quoteId);
}