<?php

namespace Application\Exception;

use Exception;
use Hyperf\Contract\TranslatorInterface;
use Hyperf\Di\Annotation\Inject;

class NothingToUpdateException extends Exception
{
    public function __construct($message = 'Nothing to update', $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}