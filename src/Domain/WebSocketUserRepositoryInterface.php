<?php

namespace Domain;

use Application\DTO\User\UserDTO;

interface WebSocketUserRepositoryInterface
{
    public function userConnection(UserDTO $user): bool;
    public function getUserIdConnection(string $userId): int;
    public function userDisconnection(int $fd): bool;
}