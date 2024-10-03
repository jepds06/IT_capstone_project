<?php

namespace App\Interface\Repository;

interface UserAuthRepositoryInterface
{
    public function findByEmail(string $email);
}