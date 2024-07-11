<?php

namespace Application\UseCase\EmailTemplate;

use Application\DTO\ServiceSettings\ServiceSettingsDTO;
use Domain\EmailTemplateRepositoryInterface;

class GetAllByServiceIdEmailTemplates
{
    private EmailTemplateRepositoryInterface $emailTemplateRepository;

    public function __construct(EmailTemplateRepositoryInterface $emailTemplateRepository)
    {
        $this->emailTemplateRepository = $emailTemplateRepository;
    }

    /**
     * @param string $serviceId
     * @return array
     */
    public function execute(string $serviceId): array
    {
        $result = $this->emailTemplateRepository->getAllByServiceIdTemplate($serviceId);

        return $result;
    }
}