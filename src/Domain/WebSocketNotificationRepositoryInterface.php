<?php

namespace Domain;

use Application\DTO\WebSocketNotification\WebSocketNotificationDTO;
use Domain\Entity\WebSocketNotification;

interface WebSocketNotificationRepositoryInterface
{
    public function create(WebSocketNotificationDTO $notification): bool;

    public function getNotificationsByUserId(string $userId): array;
}