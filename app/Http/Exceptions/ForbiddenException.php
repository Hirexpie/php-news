<?php

namespace App\Http\Exceptions;

class ForbiddenException extends ApiRequestException {
    public function __construct(string $message = 'Not Found')
    {
        parent::__construct($message, 403);
    }
}