<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Contracts\AuthServiceInterface;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Requests\Api\RegisterRequest;

class UserAuthController extends Controller
{
    private $authService;
    public function __construct(AuthServiceInterface $authService)
    {
        $this->authService = $authService;
    }
    public function register(RegisterRequest $request)
    {
        return $this->authService->register($request->validated());
    }
    public function login(LoginRequest $request)
    {
        return $this->authService->login($request->validated());
    }
    public function getUser()
    {
        return $this->authService->getUser();
    }
}
