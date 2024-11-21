<?php

namespace App\Repository;

use App\Interface\Repository\SalesRepositoryInterface;
use App\Models\Sale;
use App\Models\User;

class SalesRepository implements SalesRepositoryInterface
{
    public function findMany()
    {
        return Sale::with(['salesOrders', 'salesDeliveries', 'customerPayment', 'salesOrders.product'])->paginate(10);
    }

    public function findOneById(int $salesId)
    {
        return Sale::findOrFail($salesId);
    }

    public function findManyByUserId(int $userID)
    {
        $sales = Sale::with(['salesOrders', 'salesDeliveries', 'customerPayment', 'salesOrders.product'])->where('userID', $userID)->get();

        // Iterate over the sales collection
        $sales->transform(function ($sale) {
            if ($sale->salesOrders) {
                // Iterate through salesOrders to add the image_url to products
                $sale->salesOrders->transform(function ($order) {
                    if ($order->product && $order->product->imagePath) {
                        // Generate the full URL for the stored image
                        $order->product->image_url = asset('storage/' . $order->product->imagePath);
                    } else {
                        $order->product->image_url = null; // Or set a default image URL
                    }
                    return $order;
                });
            }
            return $sale;
        });

        return $sales;
    }

    public function create(object $payload)
    {
        $sale = new Sale();

        $user = User::find($payload->userID);
        if($user){
            $sale->user()->associate($user);
        } else {
            throw new \Exception("Invalid user ID provided.");
        }

        $sale->salesDate = $payload->salesDate;

        $sale->save();
        return $sale->fresh();
    }

    public function update(object $payload, int $salesId)
    {
        $sale = Sale::findOrFail($salesId);

        $user = User::find($payload->userID);
        if($user){
            $sale->user()->associate($user);
        } else {
            throw new \Exception("Invalid user ID provided.");
        }

        $sale->salesDate = $payload->salesDate;

        $sale->save();
        return $sale->fresh();
    }
}