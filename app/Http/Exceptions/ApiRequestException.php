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
