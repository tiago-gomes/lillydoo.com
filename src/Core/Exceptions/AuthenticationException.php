<?php

namespace App\Core\Exceptions;

class AuthenticationException extends \Exception
{
    public function __construct($message = 'Unauthorized User', $code = 401, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
