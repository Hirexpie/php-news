<?php

namespace App\Http\Exceptions;

class NotFoundException extends ApiRequestException {
    public function __construct(string $message = 'не найден')
    {
        parent::__construct($message, 404);
    }
}