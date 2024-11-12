<?php

namespace App\Repository;

use App\Interface\Repository\SalesRepositoryInterface;
use App\Models\Sale;

class SalesRepository implements SalesRepositoryInterface
{
    public function findMany()
    {
        return Sale::paginate(10);
    }

    public function findOneById(int $salesId)
    {
        return Sale::findOrFail($salesId);
    }

    public function create(object $payload)
    {
        $sale = new Sale();

        $sale->salesDate = $payload->salesDate;

        $sale->save();
        return $sale->fresh();
    }

    public function update(object $payload, int $salesId)
    {
        $sale = Sale::findOrFail($salesId);

        $sale->salesDate = $payload->salesDate;

        $sale->save();
        return $sale->fresh();
    }
}