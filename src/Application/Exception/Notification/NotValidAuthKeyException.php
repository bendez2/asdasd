<?php

namespace Application\Exception\Notification;

use Exception;

class NotValidAuthKeyException extends Exception
{
    /**
     * @param $message
     * @param $code
     * @param Exception|null $previous
     */
    public function __construct($message = 'AuthKey not found', $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}