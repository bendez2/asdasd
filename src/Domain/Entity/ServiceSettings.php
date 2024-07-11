<?php

namespace Domain\Entity;



use Random\RandomException;

class ServiceSettings
{
    private string $name;
    private string $serviceApiKey;
    private string $serviceType;
    private string $authKey;
    private ?string $id;

    /**
     * @param string $name
     * @param string $serviceApiKey
     * @param string $serviceType
     * @param string|null $id
     * @throws RandomException
     * @throws RandomException
     */
    public function __construct(
        string  $name,
        string  $serviceApiKey,
        string  $serviceType,
        ?string $id = null
    )
    {
        $this->name = $name;
        $this->serviceApiKey = $serviceApiKey;
        $this->serviceType = $serviceType;
        $this->id = $id;
        $this->authKey = bin2hex(random_bytes(16));
    }

    /**
     * @return array{name: string, serviceApiKey: string, serviceType: string, id: null|string, authKey: string}
     */
    public function getData(): array
    {
        return [
            'name' => $this->name,
            'serviceApiKey' => $this->serviceApiKey,
            'serviceType' => $this->serviceType,
            'id' => $this->id,
            'authKey' => $this->authKey
        ];
    }

    /**
     * @param $data
     * @return ServiceSettings
     * @throws RandomException
     */
    public static function createFromObject($data): ServiceSettings
    {
        return new self(
            name: $data->name,
            serviceApiKey: $data->serviceApiKey,
            serviceType: $data->serviceType,
            id: $data->id,
        );
    }

    /**
     * @param array $data
     * @return self
     * @throws RandomException
     */
    public static function createFromArray(array $data): self
    {
        return new self(
            name: $data['name'],
            serviceApiKey: $data['serviceApiKey'],
            serviceType: $data['serviceType'],
            id: $data['id'],
        );
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
     * @return string
     */
    public function getServiceApiKey(): string
    {
        return $this->serviceApiKey;
    }

    /**
     * @param string $serviceApiKey
     * @return void
     */
    public function setServiceApiKey(string $serviceApiKey): void
    {
        $this->serviceApiKey = $serviceApiKey;
    }

    /**
     * @return string
     */
    public function getServiceType(): string
    {
        return $this->serviceType;
    }

    /**
     * @param string $serviceType
     * @return void
     */
    public function setServiceType(string $serviceType): void
    {
        $this->serviceType = $serviceType;
    }

    /**
     * @return string
     */
    public function getAuthKey(): string
    {
        return $this->authKey;
    }

    /**
     * @param string $authKey
     * @return void
     */
    public function setAuthKey(string $authKey): void
    {
        $this->authKey = $authKey;
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
