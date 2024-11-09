<?php

namespace App\Service;

use App\Http\Resources\QuotationDetailResource;
use App\Interface\Repository\QuotationDetailRepositoryInterface;
use App\Interface\Service\QuotationDetailServiceInterface;

class QuotationDetailService implements QuotationDetailServiceInterface
{
    private $quoteDetailRepository;

    public function __construct(QuotationDetailRepositoryInterface $quoteDetailRepository)
    {
        $this->quoteDetailRepository = $quoteDetailRepository;
    }

    public function findQuotationDetails()
    {
        $quotationDetails = $this->quoteDetailRepository->findMany();

        return QuotationDetailResource::collection($quotationDetails);
    }

    public function findQuotationDetailById(int $qteDetailId)
    {
        $quotationDetail = $this->quoteDetailRepository->findOneById($qteDetailId);

        return new QuotationDetailResource($quotationDetail);
    }

    public function createQuotationDetail(object $payload)
    {
        $quotationDetail = $this->quoteDetailRepository->create($payload);

        return new QuotationDetailResource($quotationDetail);
    }

    public function updateQuotationDetail(object $payload, int $qteDetailId)
    {
        $quotationDetail = $this->quoteDetailRepository->update($payload, $qteDetailId);

        return new QuotationDetailResource($quotationDetail);
    }

    public function findQuotationDetailsByQuoteID($quoteID)
    {
        $quotationDetail = $this->quoteDetailRepository->findManyByQuoteID($quoteID); 

        return $quotationDetail;
    }

    public function findQuotationDetailsListQuotations()
    {
        $quotationDetail = $this->quoteDetailRepository->findManyAllInfoQuotations(); 

        return $quotationDetail;
    }

    public function deleteQuotationDetail(int $qteDetailId)
    {
        $quotationDetail = $this->quoteDetailRepository->deleteByQteDetailID($qteDetailId); 

        return $quotationDetail;
    }
}