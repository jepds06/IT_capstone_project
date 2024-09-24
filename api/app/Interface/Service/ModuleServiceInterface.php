<?php

namespace App\Interface\Service;

interface ModuleServiceInterface
{
    public function findModules();

    public function findModuleById(int $moduleId);

    public function createModule(object $payload);

    public function updateModule(object $payload, int $moduleId);
}