<?php

namespace Application\DTO\EmailTemplate;

class EmailTemplateDTO
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
        string $serviceId,
        string $templateName,
        string $senderName,
        string $senderEmail,
        string $bodyEmail,
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
     * @return EmailTemplateDTO
     */
    public static function createFromObject($data): EmailTemplateDTO
    {
        return new self(
            serviceId: $data->serviceId,
            templateName: $data->templateName,
            senderName: $data->senderName,
            senderEmail: $data->senderEmail,
            bodyEmail: $data->bodyEmail,
            id: $data->id,
        );
    }

    /**
     * @return array
     */
    public function getArray(): array
    {
        return [
            'serviceId' => $this->serviceId,
            'templateName' => $this->templateName,
            'senderName' => $this->senderName,
            'senderEmail' => $this->senderEmail,
            'bodyEmail' => $this->bodyEmail,
            'id' => $this->id,
        ];
    }
}