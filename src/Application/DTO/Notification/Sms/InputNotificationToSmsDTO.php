<?php

namespace Application\DTO\Notification\Sms;

class InputNotificationToSmsDTO
{
    /**
     * @param string $authKey
     * @param string $templateId
     * @param string $phone
     * @param array $preload
     */
    public function __construct(
        public readonly string $authKey,
        public readonly string    $templateId,
        public readonly string $phone,
        public readonly array  $preload = []
    )
    {

    }
}