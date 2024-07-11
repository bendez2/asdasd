<?php

namespace Application\Exception;

use Exception;

class ValidationFailedException extends Exception
{
    public function __construct($message = 'Error validation', $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}