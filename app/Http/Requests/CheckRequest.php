<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Tymon\JWTAuth\Facades\JWTAuth;
use \Tymon\JWTAuth\Exceptions\JWTException;

class CheckRequest extends FormRequest
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
            //
        ];
    }
}
