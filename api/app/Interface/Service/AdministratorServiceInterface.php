<?php

namespace App\Interface\Service;

interface AdministratorServiceInterface
{
    public function findAdministrators();

    public function findAdminById(int $adminId);

    public function createAdmin(object $payload);

    public function updateAdmin(object $payload, int $adminId);

    public function deleteAdmin(int $adminId);
}