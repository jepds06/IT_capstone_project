<?php

namespace App\Service;

use App\Http\Resources\CustomerResource;
use App\Interface\Repository\CustomerRepositoryInterface;
use App\Interface\Service\CustomerServiceInterface;

class CustomerService implements CustomerServiceInterface
{
    private $customerRepository;

    public function __construct(CustomerRepositoryInterface $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    public function findCustomers()
    {
        $customers = $this->customerRepository->findMany();

        return CustomerResource::collection($customers);
    }

    public function findCustomerById(int $cstrId)
    {
        $customer = $this->customerRepository->findOneById($cstrId);

        return new CustomerResource($customer);
    }

    public function createCustomer(object $payload)
    {
        $customer = $this->customerRepository->create($payload);

        return new CustomerResource($customer);
    }

    public function updateCustomer(object $payload, int $cstrId)
    {
        $customer = $this->customerRepository->update($payload, $cstrId);

        return new CustomerResource($customer);
    }

    public function deleteCustomer(int $cstrId)
    {
        return $this->customerRepository->delete($cstrId);
    }
}