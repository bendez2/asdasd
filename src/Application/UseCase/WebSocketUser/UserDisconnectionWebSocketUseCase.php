<?php

namespace Application\UseCase\WebSocketUser;

use Application\DTO\User\UserDTO;
use Common\Constants\ErrorCode;
use Common\Exception\BusinessException;
use Domain\WebSocketUserRepositoryInterface;
use Hyperf\Contract\TranslatorInterface;
use Hyperf\Di\Annotation\Inject;

class UserDisconnectionWebSocketUseCase
{
    #[Inject]
    private TranslatorInterface $translator;
    #[Inject]
    private WebSocketUserRepositoryInterface $user_repository;

    /**
     * @param int $fd
     * @return bool
     */
    public function execute(int $fd): bool
    {
        $resultConnection = $this->user_repository->userDisconnection($fd);

        if(!$resultConnection){
            throw new BusinessException(ErrorCode::SERVER_ERROR,  $this->translator->trans('messages.errorDisconnection'));
        }

        return true;
    }
}