<?php

namespace Application\DTO\WebSocketNotification;

class WebSocketNotificationDTO
{
    /**
     * @param string $userId
     * @param string $applicationId
     * @param string $message
     */
    public function __construct(
        public readonly string $userId,
        public readonly string $applicationId,
        public readonly string $message
    )
    {

    }
}