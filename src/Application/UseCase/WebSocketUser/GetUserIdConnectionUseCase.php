<?php

namespace Application\UseCase\WebSocketUser;

use Common\Constants\ErrorCode;
use Common\Exception\BusinessException;
use Domain\WebSocketUserRepositoryInterface;
use Hyperf\Di\Annotation\Inject;

class GetUserIdConnectionUseCase
{
    #[Inject]
    private WebSocketUserRepositoryInterface $userRepository;

    /**
     * @param string $userId
     * @return int
     */
    public function execute(string $userId): int
    {
        $id = $this->userRepository->getUserIdConnection($userId);

        return $id;
    }
}