<?php

namespace App\Contracts;

use App\Models\User;

interface AuthServiceInterface
{
    public function register(array $data): string;
    public function login(array $credentials): string;
    public function getUser(): string;
}
