<?php

namespace App\Service;

use App\Http\Resources\QuotationResource;
use App\Interface\Repository\QuotationRepositoryInterface;
use App\Interface\Service\QuotationServiceInterface;

class QuotationService implements QuotationServiceInterface
{
    private $quotationRepository;

    public function __construct(QuotationRepositoryInterface $quotationRepository)
    {
        $this->quotationRepository = $quotationRepository;
    }

    public function findQuotations()
    {
        $quotations = $this->quotationRepository->findMany();

        return QuotationResource::collection($quotations);
    }

    public function findQuotationById(int $quoteId)
    {
        $quotation = $this->quotationRepository->findOneById($quoteId);

        return new QuotationResource($quotation);
    }

    public function createQuotation(object $payload)
    {
        $quotation = $this->quotationRepository->create($payload);

        return new QuotationResource($quotation);
    }

    public function updateQuotation(object $payload, int $quoteId)
    {
        $quotation = $this->quotationRepository->update($payload, $quoteId);

        return new QuotationResource($quotation);
    }
}