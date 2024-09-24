<?php

namespace App\Service;

use App\Http\Resources\ModuleResource;
use App\Interface\Repository\ModuleRepositoryInterface;
use App\Interface\Service\ModuleServiceInterface;
use App\Models\Module;

class ModuleService implements ModuleServiceInterface
{
    private $moduleRepository;

    public function __construct(ModuleRepositoryInterface $moduleRepository)
    {
        $this->moduleRepository = $moduleRepository;
    }

    public function findModules()
    {
        $modules = $this->moduleRepository->findMany();

        return ModuleResource::collection($modules);
    }

    public function findModuleById(int $moduleId)
    {
        $module = $this->moduleRepository->findOneById($moduleId);

        return new ModuleResource($module);
    }

    public function createModule(object $payload)
    {
        $module = $this->moduleRepository->create($payload);

        return new ModuleResource($module);
    }

    public function updateModule(object $payload, int $moduleId)
    {
        $module = $this->moduleRepository->update($payload, $moduleId);

        return new ModuleResource($module);
    }
}