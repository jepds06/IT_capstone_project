<?php

namespace App\Interface\Repository;

interface ModuleRepositoryInterface
{
    public function findMany();

    public function findOneById(int $moduleId);

    public function create(object $payload);

    public function update(object $payload, int $moduleId);
}