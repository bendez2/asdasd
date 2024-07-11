<?php

namespace Application\UseCase\ServiceSettings;

use Application\DTO\ServiceSettings\ServiceSettingsDTO;
use Domain\ServiceSettingsRepositoryInterface;

class RemoveByAuthKeyServiceSettings
{
    private ServiceSettingsRepositoryInterface $serviceRepository;

    public function __construct(ServiceSettingsRepositoryInterface $serviceRepository)
    {
        $this->serviceRepository = $serviceRepository;
    }

    /**
     * @param string $authKey
     * @return bool
     */
    public function execute(string $authKey): bool
    {
        $serviceSettings = $this->serviceRepository->removeByAuthKey($authKey);

        return $serviceSettings;
    }
}