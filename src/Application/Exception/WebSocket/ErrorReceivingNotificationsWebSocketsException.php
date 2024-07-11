<?php

namespace Application\Exception\WebSocket;

use Exception;

class ErrorReceivingNotificationsWebSocketsException extends Exception
{
    /**
     * @param $message
     * @param $code
     * @param Exception|null $previous
     */
    public function __construct($message = 'Error when receiving notifications web socket', $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}