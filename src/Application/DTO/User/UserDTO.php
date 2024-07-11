<?php

namespace Application\DTO\User;

class UserDTO
{
    public function __construct(
        public readonly int    $fd,
        public readonly string $userId,
        public readonly string $applicationId,
        public readonly string $jwt
    )
    {

    }

}