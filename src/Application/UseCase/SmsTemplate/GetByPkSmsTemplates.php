<?php

namespace Application\UseCase\SmsTemplate;

use Application\DTO\EmailTemplate\EmailTemplateDTO;
use Application\DTO\SmsTemplate\SmsTemplateDTO;
use Domain\EmailTemplateRepositoryInterface;
use Domain\SmsTemplateRepositoryInterface;

class GetByPkSmsTemplates
{
    private SmsTemplateRepositoryInterface $smsTemplateRepository;

    public function __construct(SmsTemplateRepositoryInterface $smsTemplateRepository)
    {
        $this->smsTemplateRepository = $smsTemplateRepository;
    }

    /**
     * @param string $pk
     * @return SmsTemplateDTO
     */
    public function execute(string $pk): SmsTemplateDTO
    {
        $template = $this->smsTemplateRepository->getByPk($pk);

        return $template;
    }
}