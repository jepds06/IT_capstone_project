<?php

namespace App\Repository;

use App\Interface\Repository\ProductionRepositoryInterface;
use App\Models\Production;
use App\Models\User;

class ProductionRepository implements ProductionRepositoryInterface
{
    public function findMany()
    {
        return Production::paginate(10);
    }

    public function findOneById(int $productionId)
    {
        return Production::with(['quotations', 'quotations.adminOrders', 'quotations.adminOrders.adminDeliveries'])->findOrFail($productionId);
    }

    public function create(object $payload)
    {
        $production = new Production();
        $user = User::find($payload->userID);

        if($user){
            $production->user()->associate($user);
        } else {
            // Handle the error: throw an exception, return an error response, or set a default value
            throw new \Exception("Invalid account type ID provided.");
        }
        $production->startDate = $payload->startDate;
        $production->completionDate = $payload->completionDate;
        $production->remarks = $payload->remarks;
        $production->status = $payload->status;

        $production->save();

        return $production->fresh();
    }
    public function update(object $payload, int $productionId)
    {
        $production = Production::findOrFail($productionId);
        $user = User::find($payload->userID);

        if($user){
            $production->user()->associate($user);
        } else {
            // Handle the error: throw an exception, return an error response, or set a default value
            throw new \Exception("Invalid user ID provided.");
        }
        $production->startDate = $payload->startDate;
        $production->completionDate = $payload->completionDate;
        $production->remarks = $payload->remarks;
        $production->status = $payload->status;

        $production->save();

        return $production->fresh();
    }
}