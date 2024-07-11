<?php

namespace Application\Repository;

use Application\DTO\WebSocketNotification\WebSocketNotificationDTO;
use Application\Exception\ErrorCreatingException;
use Common\Constants\ErrorCode;
use Common\Exception\BusinessException;
use Domain\Entity\WebSocketNotification;
use Domain\WebSocketNotificationRepositoryInterface;
use Hyperf\Contract\TranslatorInterface;
use Hyperf\DbConnection\Db;
use Hyperf\Di\Annotation\Inject;

class WebSocketNotificationRepository implements WebSocketNotificationRepositoryInterface
{
    #[Inject]
    private TranslatorInterface $translator;

    /**
     * @param WebSocketNotificationDTO $notification
     * @return bool
     * @throws ErrorCreatingException
     */
    public function create(WebSocketNotificationDTO $notification): bool
    {
        $entity = new WebSocketNotification(
            userId: $notification->userId,
            applicationId: $notification->applicationId,
            message: $notification->message
        );

        $result = DB::table('notifications')->insert(
            [
                'user_id' => $entity->getUserId(),
                'application_id' => $entity->getApplicationId(),
                'message' => $entity->getMessage()
            ]
        );

        if (!$result) {
            throw new ErrorCreatingException( $this->translator->trans('messages.errorSavingNotification'),ErrorCode::SERVER_ERROR);
        }

        return true;
    }

    /**
     * @param string $userId
     * @return array
     */
    public function getNotificationsByUserId(string $userId): array
    {
        $notifications = DB::table('notifications')->where('user_id', $userId)->get();

        $pushedNotifications = [];

        foreach ($notifications as $notification) {
            $pushedNotifications[] = new WebSocketNotificationDTO(
                userId: $notification->user_id,
                applicationId: $notification->application_id,
                message: $notification->message
            );
        }

        DB::table('notifications')->where('user_id', $userId)->delete();

        return $pushedNotifications;
    }
}