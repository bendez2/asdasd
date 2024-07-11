<?php


namespace Domain\Entity;


class WebSocketNotification
{
    private string $userId;
    private string $applicationId;
    private string $message;

    /**
     * @param string $userId
     * @param string $applicationId
     * @param string $message
     */
    public function __construct(string $userId, string $applicationId, string $message)
    {
        $this->userId = $userId;
        $this->applicationId = $applicationId;
        $this->message = $message;
    }

    /**
     * @param array $data
     * @return WebSocketNotification
     */
    public function createFromArray(array $data): WebSocketNotification
    {
        return new self($data['userId'], $data['applicationId'], $data['message']);
    }

    /**
     * @param $data
     * @return WebSocketNotification
     */
    public function createFromObject($data): WebSocketNotification
    {
        return new self($data['userId'], $data['applicationId'], $data['message']);
    }

    /**
     * @return array
     */
    public function getArray(): array
    {
        return [
            'userId' => $this->userId,
            'applicationId' => $this->applicationId,
            'message' => $this->message
        ];
    }

    /**
     * @return string
     */
    public function getUserId(): string
    {
        return $this->userId;
    }

    /**
     * @return string
     */
    public function getApplicationId(): string
    {
        return $this->applicationId;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param string $userId
     */
    public function setUserId(string $userId): void
    {
        $this->userId = $userId;
    }

    /**
     * @param string $applicationId
     */
    public function setApplicationId(string $applicationId): void
    {
        $this->applicationId = $applicationId;
    }

    /**
     * @param string $message
     */
    public function setMessage(string $message): void
    {
        $this->message = $message;
    }
}

