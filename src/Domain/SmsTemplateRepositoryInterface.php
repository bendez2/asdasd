<?php

namespace Domain;




use Application\DTO\SmsTemplate\SmsTemplateDTO;
use Application\DTO\SmsTemplate\CreateCompanySmsTemplateDTO;

interface SmsTemplateRepositoryInterface
{
    /**
     * @param SmsTemplateDTO $smsTemplateDTO
     * @return bool
     */
    public function create(SmsTemplateDTO $smsTemplateDTO): bool;

    /**
     * @param string $serviceId
     * @return array
     */
    public function getAllByServiceId(string $serviceId): array;

    /**
     * @param string $pk
     * @return SmsTemplateDTO
     */
    public function getByPk(string $pk): SmsTemplateDTO;

    /**
     * @param string $pk
     * @return bool
     */
    public function removeByPk(string $pk): bool;

    /**
     * @param SmsTemplateDTO $smsTemplateDTO
     * @return bool
     */
    public function updateTemplate(SmsTemplateDTO $smsTemplateDTO): bool;
}