<?php

namespace Application\Exception\WebSocket;

use Exception;

class ErrorConnectionToWebSocketException extends Exception
{
    /**
     * @param $message
     * @param $code
     * @param Exception|null $previous
     */
    public function __construct($message = 'Error connection', $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}