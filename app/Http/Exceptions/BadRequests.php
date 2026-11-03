<?php

namespace App\Http\Exceptions;
use Exception;

abstract class ApiRequestException extends Exception {
    public function __construct(
        string $message,
        public readonly int $status
    ) {
        parent::__construct($message);
    }
}

class BadRequestException extends ApiRequestException {
    public function __construct(string $message = 'Ошибка на стороне пользавателья')
    {
        parent::__construct($message, 400);
    }
}

class NotFoundException extends ApiRequestException {
    public function __construct(string $message = 'не найден')
    {
        parent::__construct($message, 404);
    }
}

class ForbiddenException extends ApiRequestException {
    public function __construct(string $message = 'Not Found')
    {
        parent::__construct($message, 403);
    }
}

class UnauthorizedException extends ApiRequestException
{
    public function __construct(string $message = 'Unauthorized')
    {
        parent::__construct($message, 401);
    }
}