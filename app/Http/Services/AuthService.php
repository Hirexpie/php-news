<?php 

namespace App\Http\Services;

use App\Http\Validator\AuthValidator;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth; 


class AuthService {
    private AuthValidator $authValidator;
    public function __construct()
    {
        $this->authValidator = new AuthValidator();
    }

    public function register(Request $req) {
        $validate = $this->authValidator->singValidator($req);
        if ($validate !== null) {
            return $validate;
        }
        $userExists = User::where('name', $req->login)->exists();
        if ($userExists) {
            return response()->json('логин или пароль не верны', 409);
        }
        $user = User::create([
            'name' => $req->login,
            'password_hash' => Hash::make($req->password),
        ]);
        return response()->json([
            'message' => 'Пользователь успешно зарегистрирован'
        ], 201);
    }

    public function login(Request $req) {
        $validate = $this->authValidator->singValidator($req);
        if ($validate !== null) {
            return $validate;
        }
        $user = User::where('name', $req->login)->first();
        if (!$user || !Hash::check($req->password, $user->password_hash)) {
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