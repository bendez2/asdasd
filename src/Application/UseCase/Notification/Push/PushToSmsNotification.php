<?php

namespace Application\UseCase\Notification\Push;

use Application\DTO\Notification\Sms\InputNotificationToSmsDTO;
use Application\DTO\Notification\Sms\NotificationToSmsDTO;
use Domain\NotificationRepositoryInterface;

class PushToSmsNotification
{
    private NotificationRepositoryInterface $notificationRepository;

    public function __construct(NotificationRepositoryInterface $notificationRepository)
    {
        $this->notificationRepository = $notificationRepository;
    }

    /**
     * @param NotificationToSmsDTO $notification
     * @return void
     */
    public function execute(NotificationToSmsDTO $notification): void
    {
        $this->notificationRepository->pushToSMS($notification);
    }
}