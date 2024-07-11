<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */

namespace Ports\Controller;

use Application\DTO\User\UserDTO;
use Application\UseCase\WebSocketUser\UserConnectionWebSocketUseCase;
use Application\UseCase\WebSocketUser\UserDisconnectionWebSocketUseCase;
use Hyperf\Contract\OnCloseInterface;
use Hyperf\Contract\OnMessageInterface;
use Hyperf\Contract\OnOpenInterface;

class WebSocketController implements OnMessageInterface, OnOpenInterface, OnCloseInterface
{
    public function onMessage($server,  $frame): void
    {
        $server->push($frame->fd, 'Recv: ' . 'asd');
    }

    public function onClose($server, int $fd, int $reactorId): void
    {
        $use_case = new UserDisconnectionWebSocketUseCase();

        $use_case->execute($fd);
    }

    public function onOpen($server, $request): void
    {
        var_dump($request->header);
        if (!isset($request->header['jwt']) && !isset($request->header['application_id']))
        {
            $server->close($request->fd);
        }

        $tokenData = $request->header['jwt'];

        list($header, $payload, $signature) = explode('.', $request->header['jwt']);
        $payloadAsString = base64_decode($payload);
        $userId = json_decode($payloadAsString)->userId;

        $userDto = new UserDTO(
            fd: $request->fd,
            userId: $userId,
            applicationId: $request->header['application_id'],
            jwt: $request->header['jwt']
        );

        $result = (new UserConnectionWebSocketUseCase())->execute($userDto);

        $server->push($userDto->fd, json_encode($result));
    }
}