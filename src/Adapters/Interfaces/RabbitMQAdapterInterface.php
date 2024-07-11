<?php

namespace Adapters\Interfaces;

use Application\DTO\Notification\Email\NotificationToEmailDTO;
use Application\DTO\Notification\Sms\NotificationToSmsDTO;
use Application\DTO\WebSocketNotification\WebSocketNotificationDTO;

interface RabbitMQAdapterInterface
{
    public function pushToEmail(NotificationToEmailDTO $notificationToEmailDTO): void;
    public function pushToSms(NotificationToSmsDTO $notificationToSmsDTO): void;
    public function pushToWebSocket(WebSocketNotificationDTO $webSocketNotificationDTO): void;
}