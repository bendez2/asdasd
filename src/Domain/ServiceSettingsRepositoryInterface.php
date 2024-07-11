<?php

namespace Domain;


use Application\DTO\ServiceSettings\ServiceSettingsDTO;
use Application\DTO\ServiceSettings\CompanyServiceSettingsUpdateEmailDTO;
use Application\DTO\ServiceSettings\CompanyServiceSettingsUpdateTelegramDTO;
use Application\DTO\ServiceSettings\CompanyServiceSettingsUpdateVKDTO;

interface ServiceSettingsRepositoryInterface
{
    public function create(ServiceSettingsDTO $serviceSettingsDTO): string;

    public function removeByAuthKey(string $authKey): bool;

    public function updateByAuthKey(ServiceSettingsDTO $serviceSettingsDTO): bool;

    public function getByAuthKey(string $authKey): ServiceSettingsDTO;
}