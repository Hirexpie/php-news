<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
 
    public function definition(): array
    {
        return [
            'name' => 'string',
            'password_hash' => 'string',
        ];
    }

}
