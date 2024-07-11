<?php

namespace Application\UseCase\Notification\Save;

use Application\DTO\WebSocketNotification\WebSocketNotificationDTO;
use Domain\NotificationRepositoryInterface;

class SaveWebSocketNotificationUseCase
{
    private NotificationRepositoryInterface $notificationRepository;

    public function __construct(NotificationRepositoryInterface $notificationRepository)
    {
        $this->notificationRepository = $notificationRepository;
    }

    public function execute(WebSocketNotificationDTO $notification): bool
    {
        $result = $this->notificationRepository->saveWebSocketNotification($notification);

        return $result;
    }
}