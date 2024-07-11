<?php

namespace Application\UseCase\EmailTemplate;

use Domain\EmailTemplateRepositoryInterface;

class RemoveByPkEmailTemplate
{
    private EmailTemplateRepositoryInterface $emailTemplateRepository;

    public function __construct(EmailTemplateRepositoryInterface $emailTemplateRepository)
    {
        $this->emailTemplateRepository = $emailTemplateRepository;
    }

    /**
     * @param string $pk
     * @return bool
     */
    public function execute(string $pk): bool
    {
        $result = $this->emailTemplateRepository->removeByPk($pk);

        return $result;
    }
}