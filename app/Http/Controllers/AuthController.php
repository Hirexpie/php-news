<?php

namespace App\Http\Controllers;

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
    public function register(Request $request)
    {
        
        return $this->authService->register($request->login, $request->password);
    }
    public function login(Request $request)
    {
       
        return $this->authService->login($request->login, $request->password);
    }
   
}