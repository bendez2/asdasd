<?php

namespace Domain\Entity;


class EmailTemplate
{
    public string $serviceId;
    public string $templateName;
    public string $senderName;
    public string $senderEmail;
    public string $bodyEmail;
    public ?string $id;


    /**
     * @param string $serviceId
     * @param string $templateName
     * @param string $senderName
     * @param string $senderEmail
     * @param string $bodyEmail
     * @param string|null $id
     */
    public function __construct(
        string  $serviceId,
        string  $templateName,
        string  $senderName,
        string  $senderEmail,
        string  $bodyEmail,
        ?string $id = null
    )
    {
        $this->serviceId = $serviceId;
        $this->templateName = $templateName;
        $this->senderName = $senderName;
        $this->senderEmail = $senderEmail;
        $this->bodyEmail = $bodyEmail;
        $this->id = $id;
    }


    /**
     * @param $data
     * @return EmailTemplate
     */
    public static function createFromObject($data): EmailTemplate
    {
        return new self(
            serviceId: $data->serviceId,
            templateName: $data->templateName,
            senderName: $data->senderName,
            senderEmail: $data->senderEmail,
            bodyEmail: $data->bodyEmail,
            id: $data->id
        );
    }

    /**
     * @param $data
     * @return EmailTemplate
     */
    public static function createFromArray($data): EmailTemplate
    {
        return new self(
            serviceId: $data['serviceId'],
            templateName: $data["templateName"],
            senderName: $data["senderName"],
            senderEmail: $data["senderEmail"],
            bodyEmail: $data["bodyEmail"],
            id: $data["id"]
        );
    }

    /**
     * @return array
     */
    public function getArray(): array
    {
        return [
            "serviceId" => $this->serviceId,
            'templateName' => $this->templateName,
            'senderName' => $this->senderName,
            'senderEmail' => $this->senderEmail,
            'bodyEmail' => $this->bodyEmail,
            'id' => $this->id
        ];
    }

    /**
     * @return string
     */
    public function getServiceId(): string
    {
        return $this->serviceId;
    }

    /**
     * @param string $serviceId
     * @return void
     */
    public function setServiceId(string $serviceId): void
    {
        $this->serviceId = $serviceId;
    }

    /**
     * @return string
     */
    public function getTemplateName(): string
    {
        return $this->templateName;
    }

    /**
     * @param string $templateName
     * @return void
     */
    public function setTemplateName(string $templateName): void
    {
        $this->templateName = $templateName;
    }

    /**
     * @return string
     */
    public function getSenderName(): string
    {
        return $this->senderName;
    }

    /**
     * @param string $senderName
     * @return void
     */
    public function setSenderName(string $senderName): void
    {
        $this->senderName = $senderName;
    }

    /**
     * @return string
     */
    public function getSenderEmail(): string
    {
        return $this->senderEmail;
    }

    /**
     * @param string $senderEmail
     * @return void
     */
    public function setSenderEmail(string $senderEmail): void
    {
        $this->senderEmail = $senderEmail;
    }

    /**
     * @return string
     */
    public function getBodyEmail(): string
    {
        return $this->bodyEmail;
    }

    /**
     * @param string $bodyEmail
     * @return void
     */
    public function setBodyEmail(string $bodyEmail): void
    {
        $this->bodyEmail = $bodyEmail;
    }

    /**
     * @return string|null
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @param string|null $id
     * @return void
     */
    public function setId(?string $id): void
    {
        $this->id = $id;
    }


}