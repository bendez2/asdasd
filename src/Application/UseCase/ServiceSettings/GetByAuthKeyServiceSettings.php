<?php

namespace Application\UseCase\ServiceSettings;

use Application\DTO\ServiceSettings\ServiceSettingsDTO;
use Domain\ServiceSettingsRepositoryInterface;

class GetByAuthKeyServiceSettings
{
    private ServiceSettingsRepositoryInterface $serviceRepository;

    public function __construct(ServiceSettingsRepositoryInterface $serviceRepository)
    {
        $this->serviceRepository = $serviceRepository;
    }

    /**
     * @param string $authKey
     * @return ServiceSettingsDTO
     */
    public function execute(string $authKey): ServiceSettingsDTO
    {
        $serviceSetting = $this->serviceRepository->getByAuthKey($authKey);

        return $serviceSetting;
    }
}