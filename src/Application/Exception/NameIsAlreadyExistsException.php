<?php

namespace Application\Exception;

use Exception;

class NameIsAlreadyExistsException extends Exception
{
    /**
     * @param $message
     * @param $code
     * @param Exception|null $previous
     */
    public function __construct($message = 'This name is already exists', $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}