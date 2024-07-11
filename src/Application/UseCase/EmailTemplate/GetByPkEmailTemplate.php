<?php

namespace Application\UseCase\EmailTemplate;

use Application\DTO\EmailTemplate\EmailTemplateDTO;
use Domain\EmailTemplateRepositoryInterface;

class GetByPkEmailTemplate
{
    private EmailTemplateRepositoryInterface $emailTemplateRepository;

    public function __construct(EmailTemplateRepositoryInterface $emailTemplateRepository)
    {
        $this->emailTemplateRepository = $emailTemplateRepository;
    }

    /**
     * @param string $pk
     * @return EmailTemplateDTO
     */
    public function execute(string $pk): EmailTemplateDTO
    {
        $template = $this->emailTemplateRepository->getByPk($pk);

        return $template;
    }
}