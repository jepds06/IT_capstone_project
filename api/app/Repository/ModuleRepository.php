<?php

namespace App\Repository;

use App\Interface\Repository\ModuleRepositoryInterface;
use App\Models\Module;

class ModuleRepository implements ModuleRepositoryInterface
{
    public function findMany()
    {
        return Module::paginate(10);
    }
    public function findOneById(int $moduleId)
    {
        return Module::findOrFail($moduleId);
    }

    public function create(object $payload)
    {
        $module = new Module();
        $module->moduleName = $payload->moduleName;
        $module->save();

        return $module->fresh();
    }

    public function update(object $payload, int $moduleId)
    {
        $module = Module::findOrFail($moduleId);
        $module->moduleName = $payload->moduleName;
        $module->save();

        return $module->fresh();
    }
}