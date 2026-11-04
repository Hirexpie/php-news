<?php

namespace App\Http\Exceptions;

class BadRequestException extends ApiRequestException {
    public function __construct(string $message = 'Ошибка на стороне пользавателья')
    {
        parent::__construct($message, 400);
    }
}