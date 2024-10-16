<?php

namespace App\Repository;

use App\Interface\Repository\QuotationDetailRepositoryInterface;
use App\Models\ProductionMaterial;
use App\Models\Quotation;
use App\Models\QuotationDetail;

class QuotationDetailRepository implements QuotationDetailRepositoryInterface
{
    public function findMany()
    {
        return QuotationDetail::paginate(10);
    }


    public function findManyByQuoteID($quoteID)
    {
        $quotation = Quotation::with([
            'quotationDetails.productionMaterial.productMaterial.material'
        ])->find($quoteID);

        if (!$quotation) {
            return response()->json(['message' => 'Quotation not found'], 404);
        }

        return response()->json($quotation);
    }

    public function findOneById(int $qteDetailId)
    {
        return QuotationDetail::findOrFail($qteDetailId);
    }

    public function create(object $payload)
    {
        $qteDetail = new QuotationDetail();
        $quotation = Quotation::find($payload->quoteID);

        if($quotation){
            $qteDetail->quotation()->associate($quotation);
        } else {
            throw new \Exception("Invalid quotation ID provided.");
        }

        $prodtnMaterial = ProductionMaterial::find($payload->prodtnMtrlID);

        if($prodtnMaterial){
            $qteDetail->productionMaterial()->associate($prodtnMaterial);
        } else {
            throw new \Exception("Invalid production material ID provided.");
        }

        $qteDetail->quantity = $payload->quantity;
        $qteDetail->quotePrice = $payload->quotePrice;
        $qteDetail->save();

        return $qteDetail->fresh();
    }

    public function update(object $payload, int $qteDetailId)
    {
        $qteDetail = QuotationDetail::findOrFail($qteDetailId);
        $quotation = QuotationDetail::find($payload->quoteID);

        if($quotation){
            $qteDetail->quotation()->associate($quotation);
        } else {
            throw new \Exception("Invalid quotation ID provided.");
        }

        $prodtnMaterial = ProductionMaterial::find($payload->prodtnMtrlID);

        if($prodtnMaterial){
            $qteDetail->productionMaterial()->associate($prodtnMaterial);
        } else {
            throw new \Exception("Invalid production material ID provided.");
        }

        $qteDetail->quantity = $payload->quantity;
        $qteDetail->quotePrice = $payload->quotePrice;
        $qteDetail->save();

        return $qteDetail->fresh();
    }
}