<?php

namespace Application\Exception\WebSocket;

use Exception;

class ErrorDisconnectionToWebSocketException extends Exception
{
    /**
     * @param $message
     * @param $code
     * @param Exception|null $previous
     */
    public function __construct($message = 'Error disconnection', $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}