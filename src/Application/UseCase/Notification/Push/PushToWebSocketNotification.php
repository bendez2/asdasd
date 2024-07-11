<?php

namespace Application\UseCase\Notification\Push;

use Application\DTO\WebSocketNotification\WebSocketNotificationDTO;
use Application\UseCase\WebSocketUser\GetUserIdConnectionUseCase;
use Domain\NotificationRepositoryInterface;
use Domain\WebSocketNotificationRepositoryInterface;
use Hyperf\Context\ApplicationContext;
use Hyperf\Contract\OnMessageInterface;
use Hyperf\Di\Annotation\Inject;
use Hyperf\Server\ServerFactory;

class PushToWebSocketNotification
{
    #[Inject]
    private WebSocketNotificationRepositoryInterface $webSocketNotificationRepository;
    #[Inject]
    private NotificationRepositoryInterface $notificationRepository;

    /**
     * @param WebSocketNotificationDTO $notification
     * @return void
     */
    public function execute(WebSocketNotificationDTO $notification): void
    {
        $userIdWs = (new GetUserIdConnectionUseCase())->execute($notification->userId);

        if ($userIdWs != 0) {
            $this->notificationRepository->pushToWebSocketNotification($userIdWs,$notification);
        } else {
            $this->webSocketNotificationRepository->create($notification);
        }
    }
}