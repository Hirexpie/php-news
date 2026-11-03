<?php 

namespace App\Http\Services;

use App\Http\Exceptions\BadRequestException;
use App\Http\Exceptions\UnauthorizedException;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth; 
use App\Http\Requests\AuthRequest;

class AuthService {


    public function register(array $validatedData) {
        $userExists = User::where('name', $validatedData['login'])->exists();
        if ($userExists) {
            throw new BadRequestException("логин уже существует");
        }
        $user = User::create([
            'name' => $validatedData['login'],
            'password_hash' => Hash::make($validatedData['password']),
        ]);
    }

    public function login(array $validatedData) {
        $user = User::where('name', $validatedData['login'])->first();
        if (!$user || !Hash::check($validatedData['password'], $user->password_hash)) {
            throw new UnauthorizedException("Неверный логин или пароль");
        }
        $token = JWTAuth::fromUser($user);
        return $this->respondWithToken($token);
    }
    protected function respondWithToken(string $token)
    {
        return [
            'authorization' => [
                'token' => $token,
                'type' => 'bearer',
                'expires_in' => 3600
            ]
        ];
    }
}