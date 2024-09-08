<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminStoreRequest;
use App\Http\Requests\AdminUpdateRequest;
use App\Interface\Service\AdministratorServiceInterface;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    private $adminService;

    public function __construct(AdministratorServiceInterface $adminService)
    {
        $this->adminService = $adminService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->adminService->findAdministrators();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AdminStoreRequest $request)
    {
        return $this->adminService->createAdmin($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $adminId)
    {
        return $this->adminService->findAdminById($adminId);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AdminUpdateRequest $request, int $adminId)
    {
        return $this->adminService->updateAdmin($request, $adminId);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $adminId)
    {
        return $this->adminService->deleteAdmin($adminId);
    }
}
