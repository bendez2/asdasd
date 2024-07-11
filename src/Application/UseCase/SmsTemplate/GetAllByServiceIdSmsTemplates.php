<?php

namespace Application\UseCase\SmsTemplate;

use Application\DTO\ServiceSettings\ServiceSettingsDTO;
use Domain\EmailTemplateRepositoryInterface;
use Domain\SmsTemplateRepositoryInterface;

class GetAllByServiceIdSmsTemplates
{
    private SmsTemplateRepositoryInterface $smsTemplateRepository;

    public function __construct(SmsTemplateRepositoryInterface $smsTemplateRepository)
    {
        $this->smsTemplateRepository = $smsTemplateRepository;
    }

    /**
     * @param string $serviceId
     * @return array
     */
    public function execute(string $serviceId): array
    {
        $result = $this->smsTemplateRepository->getAllByServiceId($serviceId);

        return $result;
    }
}