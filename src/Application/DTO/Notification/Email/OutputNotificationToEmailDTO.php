<?php

namespace Application\DTO\Notification\Email;

class OutputNotificationToEmailDTO
{
    public function __construct(
        public readonly string $api_key,
        public readonly string $email,
        public readonly string $sender_email,
        public readonly string $sender_name,
        public readonly string $subject,
        public readonly string $body,
        public readonly string $list_id,
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