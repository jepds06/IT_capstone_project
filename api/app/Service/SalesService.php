<?php

namespace App\Service;

use App\Http\Resources\SalesResource;
use App\Interface\Repository\SalesRepositoryInterface;
use App\Interface\Service\SalesServiceInterface;

class SalesService implements SalesServiceInterface
{
    private $salesRepository;

    public function __construct(SalesRepositoryInterface $salesRepository)
    {
        $this->salesRepository = $salesRepository;
    }

    public function findSales()
    {
        $sales = $this->salesRepository->findMany();

        return SalesResource::collection($sales);
    }

    public function findSaleById(int $salesId)
    {
        $sale = $this->salesRepository->findOneById($salesId);

        return new SalesResource($sale);
    }

    public function createSales(object $payload)
    {
        $sale = $this->salesRepository->create($payload);

        return new SalesResource($sale);
    }

    public function updateSales(object $payload, int $salesId)
    {
        $sale = $this->salesRepository->update($payload, $salesId);

        return new SalesResource($sale);
    }

    public function findSalesByUserId(int $userID)
    
    {   $sales = $this->salesRepository->findManyByUserId($userID);

        return SalesResource::collection($sales);
    }
}