<?php

namespace Application\DTO\SmsTemplate;

class SmsTemplateDTO
{
    public string $sender;
    public string $text;
    public string $serviceId;
    public string $name;
    public ?string $id;


    /**
     * @param string $sender
     * @param string $text
     * @param string $serviceId
     * @param string $name
     * @param string|null $id
     */
    public function __construct(
        string $sender,
        string $text,
        string $serviceId,
        string $name,
        ?string $id = null,
    )
    {
        $this->sender = $sender;
        $this->text = $text;
        $this->serviceId = $serviceId;
        $this->name = $name;
        $this->id = $id;
    }


    /**
     * @param $data
     * @return SmsTemplateDTO
     */
    public static function createFromObject($data): SmsTemplateDTO
    {
        return new self(
            sender: $data->sender,
            text: $data->text,
            serviceId: $data->serviceId,
            name: $data->name,
            id: $data->id,
        );
    }

    /**
     * @return array
     */
    public function getArray(): array
    {
        return [
            'sender' => $this->sender,
            'text' => $this->text,
            'serviceId' => $this->serviceId,
            'name' => $this->name,
            'id' => $this->id,
        ];
    }
}