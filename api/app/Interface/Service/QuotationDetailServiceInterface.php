<?php

namespace App\Interface\Service;

interface QuotationDetailServiceInterface
{
    public function findQuotationDetails();

    public function findQuotationDetailsListQuotations();
    
    public function findQuotationDetailsByQuoteID($quoteID);

    public function findQuotationDetailById(int $qteDetailId);

    public function createQuotationDetail(object $payload);

    public function updateQuotationDetail(object $payload, int $qteDetailId);

    public function deleteQuotationDetail(int $qteDetailId);
}