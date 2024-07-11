<?php

namespace Domain;


use Application\DTO\EmailTemplate\EmailTemplateDTO;
use Application\DTO\EmailTemplate\CreateCompanyEmailTemplateDTO;

interface EmailTemplateRepositoryInterface
{
    public function create(EmailTemplateDTO $emailTemplateDTO): bool;

    public function getAllByServiceIdTemplate(string $serviceId, ?int $limit = 1000): array;

    public function getByPk(string $pk): EmailTemplateDTO;

    public function removeByPk(string $pk): bool;

    public function updateTemplate(EmailTemplateDTO $emailTemplateDTO): bool;
}