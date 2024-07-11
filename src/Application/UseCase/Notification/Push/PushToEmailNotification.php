<?php

namespace Application\UseCase\Notification\Push;

use Application\DTO\Notification\Email\NotificationToEmailDTO;
use Domain\NotificationRepositoryInterface;

class PushToEmailNotification
{
    private NotificationRepositoryInterface $notificationRepository;

    public function __construct(NotificationRepositoryInterface $notificationRepository)
    {
        $this->notificationRepository = $notificationRepository;
    }

    /**
     * @param NotificationToEmailDTO $notificationToEmailDTO
     * @return void
     */
    public function execute(NotificationToEmailDTO $notificationToEmailDTO): void
    {
        $this->notificationRepository->pushToEmail($notificationToEmailDTO);
    }
}