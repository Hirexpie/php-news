<?php

namespace App\Http\Controllers;

use App\Http\Exceptions\ApiRequestException;
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
    public function register(AuthRequest $req)
    {
        try {

            $validatedData = $req->validated();
            $this->authService->register($validatedData);
            return response()->json([
                'message' => 'Пользователь успешно зарегистрирован'
            ], 201);
        }
        catch (ApiRequestException $e) {
            return response()->json(['error' => $e->getMessage()], $e->status);
        }
    }
    public function login(AuthRequest $req)
    {
        try {
            $validatedData = $req->validated();
            $data = $this->authService->login($validatedData);
            return response()->json($data);
        }
        catch (ApiRequestException $e) {
            return response()->json(['error' => $e->getMessage()], $e->status);
        }
    }
   
}