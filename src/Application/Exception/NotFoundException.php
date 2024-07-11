<?php

namespace Application\Exception;

use Exception;

class NotFoundException extends Exception
{
    public function __construct($message = 'Not found', $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}