<?php 

namespace App\Http\Services;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth; 
use App\Http\Requests\AuthRequest;

class AuthService {


    public function register(AuthRequest $req) {
        $validatedData = $req->validated();
       
        $userExists = User::where('name', $validatedData->login)->exists();
        if ($userExists) {
            return response()->json('логин или пароль не верны', 409);
        }
        $user = User::create([
            'name' => $validatedData->login,
            'password_hash' => Hash::make($validatedData->password),
        ]);
        return response()->json([
            'message' => 'Пользователь успешно зарегистрирован'
        ], 201);
    }

    public function login(AuthRequest $req) {
        $validatedData = $req->validated();
        $user = User::where('name', $validatedData->login)->first();
        if (!$user || !Hash::check($validatedData->password, $user->password_hash)) {
            return response()->json([
                'error' => 'Неверный логин или пароль'
            ], 401);
        }
        $token = JWTAuth::fromUser($user);
        return $this->respondWithToken($token);
    }
    protected function respondWithToken(string $token)
    {
        return response()->json([
            'authorization' => [
                'token' => $token,
                'type' => 'bearer',
                'expires_in' => 3600
            ]
        ]);
    }
}