<?php

namespace Domain;

use Application\DTO\Notification\Email\NotificationToEmailDTO;
use Application\DTO\Notification\Sms\InputNotificationToSmsDTO;
use Application\DTO\Notification\Sms\NotificationToSmsDTO;
use Application\DTO\WebSocketNotification\WebSocketNotificationDTO;

interface NotificationRepositoryInterface
{
    public function saveEmail(NotificationToEmailDTO $notification): bool;

    public function pushToEmail(NotificationToEmailDTO $notification): void;

    public function saveSms(NotificationToSmsDTO $notification): bool;

    public function pushToSMS(NotificationToSmsDTO $notification): void;

    public function saveWebSocketNotification(WebSocketNotificationDTO $notification): bool;

    public function pushToWebSocketNotification(int $userIdWs, WebSocketNotificationDTO $notification): void;
}