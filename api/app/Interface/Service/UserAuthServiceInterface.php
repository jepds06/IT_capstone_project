<?php

namespace App\Interface\Service;

interface UserAuthServiceInterface
{
    public function authenticate(object $payload);

    public function unauthenticate(object $payload);
}