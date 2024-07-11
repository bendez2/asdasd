<?php

namespace Application\UseCase\SmsTemplate;

use Domain\EmailTemplateRepositoryInterface;
use Domain\SmsTemplateRepositoryInterface;

class RemoveByPkSmsTemplate
{
    private SmsTemplateRepositoryInterface $smsTemplateRepository;

    public function __construct(SmsTemplateRepositoryInterface $smsTemplateRepository)
    {
        $this->smsTemplateRepository = $smsTemplateRepository;
    }

    /**
     * @param string $pk
     * @return bool
     */
    public function execute(string $pk): bool
    {
        $result = $this->smsTemplateRepository->removeByPk($pk);

        return $result;
    }
}