<?php

namespace App\Http\Controllers;

use App\Http\Requests\ModuleStoreRequest;
use App\Http\Requests\ModuleUpdateRequest;
use App\Interface\Service\ModuleServiceInterface;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    private $moduleService;

    public function __construct(ModuleServiceInterface $moduleService)
    {
        $this->moduleService = $moduleService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->moduleService->findModules();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ModuleStoreRequest $request)
    {
        return $this->moduleService->createModule($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $moduleId)
    {
        return $this->moduleService->findModuleById($moduleId);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ModuleUpdateRequest $request, int $moduleId)
    {
        return $this->moduleService->updateModule($request, $moduleId);
    }
}
