<?php

namespace Application\DTO\ServiceSettings;

class ServiceSettingsDTO
{
    public string $serviceApiKey;
    public string $serviceType;
    public string $name;
    public ?string $id;
    public ?string $authKey;


    /**
     * @param string $serviceApiKey
     * @param string $serviceType
     * @param string $name
     * @param string|null $id
     * @param string|null $authKey
     */
    public function __construct(
        string  $serviceApiKey,
        string  $serviceType,
        string  $name,
        ?string $id = null,
        ?string $authKey = null
    )
    {
        $this->serviceApiKey = $serviceApiKey;
        $this->serviceType = $serviceType;
        $this->name = $name;
        $this->id = $id;
        $this->authKey = $authKey;
    }


    /**
     * @param $data
     * @return ServiceSettingsDTO
     */
    public static function createFromObject($data): ServiceSettingsDTO
    {
        return new self(
            serviceApiKey: $data->serviceApiKey,
            serviceType: $data->serviceType,
            name: $data->name,
            id: $data->id,
            authKey: $data->authKey,
        );
    }

    /**
     * @return array
     */
    public function getArray(): array
    {
        return [
            'serviceApiKey' => $this->serviceApiKey,
            'serviceType' => $this->serviceType,
            'name' => $this->name,
            'id' => $this->id,
            'authKey' => $this->authKey
        ];
    }
}