<?php

namespace App\Repository;

use App\Interface\Repository\QuotationDetailRepositoryInterface;
use App\Models\Production;
use App\Models\ProductionMaterial;
use App\Models\Quotation;
use App\Models\QuotationDetail;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class QuotationDetailRepository implements QuotationDetailRepositoryInterface
{
    public function findMany()
    {
        return QuotationDetail::paginate(10);
    }

    public function findManyAllInfoQuotations()
    {
         // Retrieve productions with their related quotations and details
        $productions = Production::with([
            'quotations.quotationDetails.productionMaterial.productMaterial.material'
        ])
        ->orderBy('dateEncoded', 'desc') // Order by production name (or any field you prefer)
        ->get();

        // Prepare the final response structure
        $response = [
            'data' => $productions,
            'count' => $productions->count(),
        ];

        return response()->json($response);
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

    public function deleteByQteDetailID($qteDetailID)
    {
        try {
            // Find the quotation detail by its ID
            $quotationDetail = QuotationDetail::find($qteDetailID);

            // Check if the record exists
            if (!$quotationDetail) {
                return response()->json([
                    'message' => 'Quotation detail not found.',
                ], Response::HTTP_NOT_FOUND);
            }

            // Delete the record
            $quotationDetail->delete();

            return response()->json([
                'message' => 'Quotation detail deleted successfully.',
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            // Log the error
            Log::error('Error deleting quotation detail', [
                'error' => $e->getMessage(),
                'qteDetailID' => $qteDetailID
            ]);

            return response()->json([
                'message' => 'Failed to delete quotation detail.',
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}