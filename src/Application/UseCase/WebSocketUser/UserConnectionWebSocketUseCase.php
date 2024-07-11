<?php

namespace Application\UseCase\WebSocketUser;

use Application\DTO\User\UserDTO;
use Common\Constants\ErrorCode;
use Common\Exception\BusinessException;
use Domain\WebSocketNotificationRepositoryInterface;
use Domain\WebSocketUserRepositoryInterface;
use Hyperf\Contract\TranslatorInterface;
use Hyperf\Di\Annotation\Inject;
use Hyperf\Translation\TranslatorFactory;

class UserConnectionWebSocketUseCase
{
    #[Inject]
    private WebSocketUserRepositoryInterface $userRepository;
    #[Inject]
    private WebSocketNotificationRepositoryInterface $notificationRepository;
    #[Inject]
    private TranslatorInterface $translator;

    /**
     * @param UserDTO $user
     * @return array
     */
    public function execute(UserDTO $user): array
    {
        $resultConnection = $this->userRepository->userConnection($user);

        if(!$resultConnection){
            throw new BusinessException(ErrorCode::SERVER_ERROR, $this->translator->trans('messages.errorConnection'));
        }

        $notifications = $this->notificationRepository->getNotificationsByUserId($user->userId);

        return $notifications;
    }
}