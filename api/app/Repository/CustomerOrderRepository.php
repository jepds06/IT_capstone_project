<?php

namespace App\Repository;

use App\Interface\Repository\CustomerOrderRepositoryInterface;
use App\Models\CustomerOrder;
use App\Models\Product;
use App\Models\ProductOrder;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class CustomerOrderRepository implements CustomerOrderRepositoryInterface
{
    public function findMany()
    {
        return CustomerOrder::paginate(10);
    }

    public function findOneById(int $cstrOrderId)
    {
        return CustomerOrder::findOrFail($cstrOrderId);
    }

    public function create(object $payload)
    {
        return DB::transaction(function() use($payload){
            $cstrOrder = new CustomerOrder();

            $user = User::find($payload->userID);
            if($user){
                $cstrOrder->user()->associate($user);
            } else {
                throw new \Exception("Invalid use ID provided.");
            }

            $cstrOrder->orderDate = $payload->orderDate;
            $cstrOrder->orderStatus = $payload->orderStatus;
            $cstrOrder->orderRemarks = $payload->orderRemarks;

            $cstrOrder->save();

            foreach ($payload->productOrders as $prodOrdDetails)
            {
                $prodOrdDetails = new ProductOrder();
                $prodOrdDetails->cstrOrderID = $payload->cstrOrderID;
                $product = Product::find($payload->productID);
                if($product){
                    $prodOrdDetails->product()->associate($product);
                } else {
                    throw new \Exception("Invalid product ID provided.");
                }
                $prodOrdDetails->quantity = $payload->quantity;
                $prodOrdDetails->unitPrice = $payload->unitPrice;
                $prodOrdDetails->save();
            }

            return $cstrOrder->fresh('productOrders');
        });
    }

    public function update(object $payload, int $cstrOrderId)
    {
        return DB::transaction(function() use($payload, $cstrOrderId){
            $cstrOrder = CustomerOrder::findOrFail($cstrOrderId);

            $user = User::find($payload->userID);
            if($user){
                $cstrOrder->user()->associate($user);
            } else {
                throw new \Exception("Invalid use ID provided.");
            }

            $cstrOrder->orderDate = $payload->orderDate;
            $cstrOrder->orderStatus = $payload->orderStatus;
            $cstrOrder->orderRemarks = $payload->orderRemarks;

            $cstrOrder->save();

            foreach ($payload->productOrders as $prodOrders)
            {
                $prodOrders = new ProductOrder();
                $prodOrders->cstrOrderID = $payload->cstrOrderID;
                $product = Product::find($payload->productID);
                if($product){
                    $prodOrders->product()->associate($product);
                } else {
                    throw new \Exception("Invalid product ID provided.");
                }
                $prodOrders->quantity = $payload->quantity;
                $prodOrders->unitPrice = $payload->unitPrice;
                $prodOrders->save();
            }

            return $cstrOrder->fresh('productOrders');
        });
    }
}