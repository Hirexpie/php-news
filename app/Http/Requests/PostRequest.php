<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    
    public function authorize(): bool
    {
        return false;
    }

   
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'desc' => ['required', 'string'],
        ];
    }
}
