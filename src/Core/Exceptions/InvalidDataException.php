<?php

namespace App\Core\Exceptions;

use Throwable;

class InvalidDataException extends \Exception
{
    public function __construct($message = 'Invalid Data', $code = 400, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
