<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Services\AuthService;

class AuthController extends Controller
{
    private AuthService $authService; 
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }
    public function register(AuthRequest $request)
    {
        return $this->authService->register($request);
    }
    public function login(AuthRequest $request)
    {
        return $this->authService->login($request);
    }
   
}