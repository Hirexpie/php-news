<?php

namespace App\Http\Exceptions;



class UnauthorizedException extends ApiRequestException
{
    public function __construct(string $message = 'Unauthorized')
    {
        parent::__construct($message, 401);
    }
}