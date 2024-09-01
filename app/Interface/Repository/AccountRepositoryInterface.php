<?php

namespace App\Interface\Repository;

interface AccountRepositoryInterface 
{
    public function findMany();

    public function findOneByID(int $accountId);

    public function create(object $payload);

    public function update(object $payload, int $accountId);

    public function delete(int $accountId);
}