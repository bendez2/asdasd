<?php

namespace Application\DTO\Notification\Sms;

class NotificationToSmsDTO
{
    public function __construct(
        public readonly string $apiKey,
        public readonly string $phone,
        public readonly string $sender,
        public string          $text
    )
    {
    }

    /**
     * @return array
     */
    public function getArray(): array
    {
        return (array)$this;
    }

}