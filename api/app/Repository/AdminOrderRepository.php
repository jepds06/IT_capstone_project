<?php

namespace App\Repository;

use App\Interface\Repository\AdminOrderRepositoryInterface;
use App\Models\AdminOrder;
use App\Models\AdminOrderDetail;
use App\Models\Quotation;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AdminOrderRepository implements AdminOrderRepositoryInterface
{
    public function findMany()
    {
        return AdminOrder::with('adminOrderDetail.productionMaterial.productMaterial.material')->paginate(10);
    }

    public function findOneById(int $adminOrderId)
    {
        return AdminOrder::findOrFail($adminOrderId);
    }

    public function create(object $payload)
    {
        return DB::transaction(function () use ($payload) {
            // Create the AdminOrder record (header)
            $adminOrder = new AdminOrder();
    
            // Validate and associate the User
            $user = User::find($payload->userID);
            if ($user) {
                $adminOrder->user()->associate($user);
            } else {
                throw new \Exception("Invalid user ID provided.");
            }
    
            // Validate and associate the Quotation
            $quote = Quotation::find($payload->quoteID);
            if ($quote) {
                $adminOrder->quotation()->associate($quote);
            } else {
                throw new \Exception("Invalid quotation ID provided.");
            }
    
            // Save initial AdminOrder record to generate an ID for it
            $adminOrder->save();
    
            // Assuming the quotation details are now provided directly in the payload
            // The structure of the quotationDetails in the payload should match the necessary fields.
            $quotationDetails = collect($payload->quotationDetails)->map(function ($item) {
                return (object) $item; // Cast each array item to an object
            });
    
            if (empty($quotationDetails)) {
                throw new \Exception("No quotation details found in the payload.");
            }
    
            // Create AdminOrderDetails records based on the provided QuotationDetails in the payload
            foreach ($quotationDetails as $quoteDetail) {
                $adminOrderDetail = new AdminOrderDetail();
                $adminOrderDetail->adminOrdID = $adminOrder->adminOrdID;
                $adminOrderDetail->prodtnMtrlID = $quoteDetail->prodtnMtrlID;
                $adminOrderDetail->qtyOrdered = $quoteDetail->qtyOrdered; // Quantity from the payload
                $adminOrderDetail->amount = $quoteDetail->amount; // Calculated amount
                $adminOrderDetail->isDropped = $quoteDetail->isDropped;
                $adminOrderDetail->save();
            }
    
            // Return the AdminOrder with details loaded
            return $adminOrder->fresh('adminOrderDetail');
        });
    }
    

    
    public function update(object $payload, int $adminOrderId)
    {
        return DB::transaction(function () use ($payload, $adminOrderId) {
            //Create the AdminOrder record (header)
            $adminOrder = AdminOrder::findOrFail($adminOrderId);

            //Validate and associate the User
            $user = User::find($payload->userID);
            if ($user) {
                $adminOrder->user()->associate($user);
            } else {
                throw new \Exception("Invalid user ID provided.");
            }

            //Validate and associate the Quotation
            $quote = Quotation::find($payload->quoteID);
            if ($quote) {
                $adminOrder->quotation()->associate($quote);
            } else {
                throw new \Exception("Invalid quotation ID provided.");
            }

            //Save initial AdminOrder record to generate an ID for it
            $adminOrder->save();

            //Retrieve QuotationDetails associated with the Quotation
            $quotationDetails = $quote->quotationDetails;

            if ($quotationDetails->isEmpty()) {
                throw new \Exception("No quotation details found for the given quotation ID.");
            }

            //Create AdminOrderDetails records based on QuotationDetails
            foreach ($quotationDetails as $quoteDetail) {
                $adminOrderDetail = new AdminOrderDetail();
                $adminOrderDetail->AdminOrderID = $adminOrder->AdminOrderID;
                $adminOrderDetail->ProductionMaterialId = $quoteDetail->ProductionMaterialId;
                $adminOrderDetail->qtyOrdered = $quoteDetail->Quantity; // Quantity from QuotationDetails
                $adminOrderDetail->amount = $quoteDetail->QuotationPrice * $quoteDetail->Quantity; // Calculated amount
                $adminOrderDetail->isDropped = $quoteDetail->isDropped;
                $adminOrderDetail->save();
            }

            //Return the AdminOrder with details loaded
            return $adminOrder->fresh('adminOrderDetails');
        });
    }
}