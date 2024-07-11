<?php

namespace Application\Repository;

use Application\DTO\User\UserDTO;
use Application\Exception\ErrorCreatingException;
use Application\Exception\WebSocket\ErrorConnectionToWebSocketException;
use Application\Exception\WebSocket\ErrorDisconnectionToWebSocketException;
use Application\Exception\WebSocket\ErrorReceivingNotificationsWebSocketsException;
use Common\Constants\ErrorCode;
use Domain\WebSocketUserRepositoryInterface;
use Hyperf\Context\ApplicationContext;
use Hyperf\Contract\TranslatorInterface;
use Hyperf\Di\Annotation\Inject;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use RedisException;

class WebSocketUserRepository implements WebSocketUserRepositoryInterface
{
    #[Inject]
    private TranslatorInterface $translator;


    /**
     * @param UserDTO $user
     * @return bool
     * @throws ContainerExceptionInterface
     * @throws ErrorConnectionToWebSocketException
     * @throws NotFoundExceptionInterface
     */
    public function userConnection(UserDTO $user): bool
    {
        try {
            $container = ApplicationContext::getContainer();
            $redis = $container->get(\Redis::class);

            $key = 'websocket_connections:session_id:' . $user->fd . '|' . $user->userId;

            $redis->set($key, json_encode($user));

            return true;
        } catch (RedisException $exception) {
            throw new ErrorConnectionToWebSocketException($this->translator->trans('messages.errorConnection'), ErrorCode::SERVER_ERROR);
        }
    }


    /**
     * @param int $fd
     * @return bool
     * @throws ContainerExceptionInterface
     * @throws ErrorDisconnectionToWebSocketException
     */
    public function userDisconnection(int $fd): bool
    {
        try {
            $container = ApplicationContext::getContainer();
            $redis = $container->get(\Redis::class);

            $cursor = '0';
            $pattern = 'websocket_connections:session_id:' . $fd . '*';

            $key = $redis->scan($cursor, $pattern);

            $redis->del($key);

            return true;
        } catch (RedisException $exception) {
            throw new ErrorDisconnectionToWebSocketException($this->translator->trans('messages.errorDisconnection'), ErrorCode::SERVER_ERROR);
        }
    }

    public function getUserIdConnection(string $userId): int
    {
        try {
            $container = ApplicationContext::getContainer();
            $redis = $container->get(\Redis::class);

            $cursor = '0';
            $pattern = 'websocket_connections:session_id:*|' . $userId;

            $key = $redis->scan($cursor, $pattern);

            if (empty($key)) {
                return 0;
            }
            $matches = [];

            preg_match('/session_id:(.*?)\|/', $key[0], $matches);

            return $matches[1];
        }
        catch (RedisException $exception) {
            throw new ErrorReceivingNotificationsWebSocketsException($this->translator->trans('messages.errorReceivingNotifications'), ErrorCode::SERVER_ERROR);
        }
    }
}