<?php 

namespace App\Http\Services;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth; 


class AuthService {
    public function register(string $login, string $password) {
        $userExists = User::where('name', $login)->exists();
        if ($userExists) {
            return response()->json('логин или пароль не верны', 409);
        }
        $user = User::create([
            'name' => $login,
            'password_hash' => Hash::make($password),
        ]);
        return response()->json([
            'message' => 'Пользователь успешно зарегистрирован'
        ], 201);
    }

    public function login(string $login, string $password) {
        $user = User::where('name', $login)->first();
        if (!$user || !Hash::check($password, $user->password_hash)) {
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