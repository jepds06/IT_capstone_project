<?php

namespace App\Service;

use App\Interface\Service\AdministratorServiceInterface;
use App\Interface\Repository\AdministratorRepositoryInterface;
use App\Http\Resources\AdminResource;

class AdministratorService implements AdministratorServiceInterface
{
    private $adminRepository;

    public function __construct(AdministratorRepositoryInterface $adminRepository)
    {
        $this->adminRepository = $adminRepository;
    }

    public function findAdministrators()
    {
        $admins = $this->adminRepository->findMany();

        return AdminResource::collection($admins);
    }

    public function findAdminById(int $adminId)
    {
        $admin = $this->adminRepository->findOneById($adminId);

        return new AdminResource($admin);
    }
    
    public function createAdmin(object $payload)
    {
        $admin = $this->adminRepository->create($payload);

        return new AdminResource($admin);
    }

    public function updateAdmin(object $payload, int $adminId)
    {
        $admin = $this->adminRepository->update($payload, $adminId);

        return new AdminResource($admin);
    }

    public function deleteAdmin(int $adminId)
    {
        return $this->adminRepository->delete($adminId);
    }
}
