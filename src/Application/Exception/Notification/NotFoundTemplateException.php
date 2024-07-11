<?php

namespace Application\Exception\Notification;

use Exception;

class NotFoundTemplateException extends Exception
{
    /**
     * @param $message
     * @param $code
     * @param Exception|null $previous
     */
    public function __construct($message = 'Template not found', $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}