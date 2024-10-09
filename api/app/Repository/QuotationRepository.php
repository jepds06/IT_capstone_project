<?php

namespace App\Repository;

use App\Interface\Repository\QuotationRepositoryInterface;
use App\Models\Quotation;
use App\Models\User;

class QuotationRepository implements QuotationRepositoryInterface
{
    public function findMany()
    {
        return Quotation::paginate(10);
    }

    public function findOneById(int $quoteId)
    {
        return Quotation::findOrFail($quoteId);
    }

    public function create(object $payload)
    {
        $quotation = new Quotation();
        $quotation->quotationDate = $payload->quotationDate;
        $user = User::find($payload->userID);

        if($user){
            $quotation->user()->associate($user);
        } else {
            throw new \Exception("Invalid user ID provided.");
        }

        $quotation->remarks = $payload->remarks;
        $quotation->save();

        return $quotation->fresh();
    }

    public function update(object $payload, int $quoteId)
    {
        $quotation = Quotation::findOrFail($quoteId);
        $quotation->quotationDate = $payload->quotationDate;
        $user = User::find($payload->userID);

        if($user){
            $quotation->user()->associate($user);
        } else {
            throw new \Exception("Invalid user ID provided.");
        }

        $quotation->remarks = $payload->remarks;
        $quotation->save();

        return $quotation->fresh();
    }
}