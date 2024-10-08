<?php

namespace App\Interface\Service;

interface QuotationServiceInterface
{
    public function findQuotations();

    public function findQuotationById(int $quoteId);

    public function createQuotation(object $payload);

    public function updateQuotation(object $payload, int $quoteId);
}