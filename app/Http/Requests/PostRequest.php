<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Foundation\Http\FormRequest;
use \Tymon\JWTAuth\Exceptions\JWTException;


class PostRequest extends FormRequest
{
    public function authorize(): bool
    {
        try {
            return JWTAuth::parseToken()->check();
        }
        catch (JWTException $e) {
            return false;
        }

    }

   
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'desc' => ['required', 'string'],
        ];
    }
}
