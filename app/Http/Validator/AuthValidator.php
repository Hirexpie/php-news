<?php
namespace App\Http\Validator;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthValidator {
    public function singValidator(Request $req) {
        $validator = Validator::make($req->all(), [
            'login' => 'required|string|max:255',
            'password' => 'required|string|min:8',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        return null;
    }
}