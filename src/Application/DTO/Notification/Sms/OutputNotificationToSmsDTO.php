<?php

namespace Application\DTO\Notification\Sms;

class OutputNotificationToSmsDTO
{
    public function __construct(
        readonly string $api_key,
        readonly string $phone,
        readonly string $sender,
        readonly string $text
    )
    {
    }

    public function getArray(): array
    {
        return (array)$this;
    }
}