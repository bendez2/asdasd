<?php

namespace Application\DTO\Notification\Email;


class NotificationToEmailDTO
{
    public string $apiKey;
    public string $email;
    public string $senderEmail;
    public string $senderName;
    public string $subject;
    public string $body;
    public ?string $list_id;


    public function __construct(
        string  $apiKey,
        string  $email,
        string  $senderEmail,
        string  $senderName,
        string  $subject,
        string  $body,
        ?string $list_id = '1'
    )
    {
        $this->apiKey = $apiKey;
        $this->email = $email;
        $this->senderEmail = $senderEmail;
        $this->senderName = $senderName;
        $this->subject = $subject;
        $this->body = $body;
        $this->list_id = $list_id;
    }

    public function getArray(): array
    {
        return [
            'apiKey' => $this->apiKey,
            'email' => $this->email,
            'senderEmail' => $this->senderEmail,
            'senderName' => $this->senderName,
            'subject' => $this->subject,
            'body' => $this->body,
            'list_id' => $this->list_id
        ];
    }
}