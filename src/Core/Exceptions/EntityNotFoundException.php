<?php

namespace App\Core\Exceptions;

use Throwable;

class EntityNotFoundException extends \Exception
{
    public function __construct($message = 'Entry not found', $code = 404, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
