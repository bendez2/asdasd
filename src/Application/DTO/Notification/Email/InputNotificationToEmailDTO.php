<?php

namespace Application\DTO\Notification\Email;


class InputNotificationToEmailDTO
{
    public string $authKey;
    public string $templateId;
    public string $employeeEmail;
    public array $preload;

    public function __construct(
        string $authKey,
        string $templateId,
        string $employeeEmail,
        array  $preload
    )
    {
        $this->authKey = $authKey;
        $this->templateId = $templateId;
        $this->employeeEmail = $employeeEmail;
        $this->preload = $preload;
    }
}