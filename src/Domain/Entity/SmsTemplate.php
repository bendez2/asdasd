<?php

namespace Domain\Entity;

use Application\DTO\SmsTemplate\SmsTemplateDTO;

class SmsTemplate
{
    private string $sender;
    private string $text;
    private string $serviceId;
    private string $name;
    private ?string $id;


    /**
     * @param string $sender
     * @param string $text
     * @param string $serviceId
     * @param string $name
     * @param string|null $id
     */
    public function __construct(
        string  $sender,
        string  $text,
        string  $serviceId,
        string  $name,
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
     * @return SmsTemplate
     */
    public static function createFromObject($data): SmsTemplate
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
     * @param array $data
     * @return SmsTemplate
     */
    public static function createFromArray(array $data): SmsTemplate
    {
        return new self(
            sender: $data['sender'],
            text: $data['text'],
            serviceId: $data['serviceId'],
            name: $data['name'],
            id: $data['id'],
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

    /**
     * @return string
     */
    public function getSender(): string
    {
        return $this->sender;
    }

    /**
     * @param string $sender
     * @return void
     */
    public function setSender(string $sender): void
    {
        $this->sender = $sender;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @param string $text
     * @return void
     */
    public function setText(string $text): void
    {
        $this->text = $text;
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
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return void
     */
    public function setName(string $name): void
    {
        $this->name = $name;
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