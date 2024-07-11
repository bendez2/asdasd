<?php

namespace Application\Exception;

use Exception;

class ErrorCreatingException extends \Exception
{
    /**
     * @param $message
     * @param $code
     * @param Exception|null $previous
     */
    public function __construct($message = 'Error creating', $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}