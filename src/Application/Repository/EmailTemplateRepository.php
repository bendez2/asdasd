<?php

namespace Application\Repository;

use Adapters\Interfaces\MongoDBAdapterInterface;
use Adapters\MongoDBAdapter;

use Application\DTO\EmailTemplate\AllCompanyEmailTemplateDTO;
use Application\DTO\EmailTemplate\EmailTemplateDTO;
use Application\DTO\EmailTemplate\CreateCompanyEmailTemplateDTO;
use Application\Exception\ErrorCreatingException;
use Application\Exception\NotFoundException;
use Application\Exception\NothingToUpdateException;
use Carbon\Carbon;
use Common\Constants\ErrorCode;
use Common\Exception\BusinessException;
use Domain\EmailTemplateRepositoryInterface;
use Domain\Entity\EmailTemplate;
use Hyperf\Contract\TranslatorInterface;
use Hyperf\Di\Annotation\Inject;
use MongoDB\BSON\ObjectId;


class EmailTemplateRepository implements EmailTemplateRepositoryInterface
{
    #[Inject]
    private MongoDBAdapterInterface $mongoDBAdapter;

    #[Inject]
    private TranslatorInterface $translator;

    /**
     * @param EmailTemplateDTO $emailTemplateDTO
     * @return bool
     * @throws ErrorCreatingException
     */
    public function create(EmailTemplateDTO $emailTemplateDTO): bool
    {
        $template = new EmailTemplate(
            serviceId: $emailTemplateDTO->serviceId,
            templateName: $emailTemplateDTO->templateName,
            senderName: $emailTemplateDTO->senderName,
            senderEmail: $emailTemplateDTO->senderEmail,
            bodyEmail: $emailTemplateDTO->bodyEmail
        );

        $collections = $this->mongoDBAdapter->mongodbDatabase->selectCollection('email-templates');

        $result = $collections->insertOne([
            'serviceId' => $template->getServiceId(),
            'templateName' => $template->getTemplateName(),
            'senderName' => $template->getSenderName(),
            'senderEmail' => $template->getSenderEmail(),
            'bodyEmail' => $template->getBodyEmail()
        ]);

        if ($result->getInsertedCount() == 0) {
            throw new ErrorCreatingException( $this->translator->trans('messages.errorCreatingNewTemplate'),ErrorCode::SERVER_ERROR);
        }

        return true;
    }

    /**
     * @param string $serviceId
     * @param int|null $limit
     * @return array
     */
    public function GetAllByServiceIdTemplate(string $serviceId, ?int $limit = 1000): array
    {
        $collections = $this->mongoDBAdapter->mongodbDatabase->selectCollection('email-templates');

        $result = $collections->find(['serviceId' => $serviceId, 'deleted_at' => null]);

        $templates = [];

        foreach ($result as $document) {
            $templates[] = new EmailTemplate(
                serviceId: $document['serviceId'],
                templateName: $document['templateName'],
                senderName: $document['senderName'],
                senderEmail: $document['senderEmail'],
                bodyEmail: $document['senderEmail'],
                id: $document['_id'],
            );
        }

        return $templates;
    }

    /**
     * @param string $pk
     * @return EmailTemplateDTO
     * @throws NotFoundException
     */
    public function GetByPk(string $pk): EmailTemplateDTO
    {
        $collections = $this->mongoDBAdapter->mongodbDatabase->selectCollection('email-templates');

        $result = $collections->findOne(['_id' => new ObjectId($pk), 'deleted_at' => null]);

        if ($result == null) {
            throw new NotFoundException( $this->translator->trans('messages.templateNotFound'),ErrorCode::SERVER_NOT_FOUND);
        }

        $template = new EmailTemplateDTO(
            serviceId: $result['serviceId'],
            templateName: $result['templateName'],
            senderName: $result['senderName'],
            senderEmail: $result['senderEmail'],
            bodyEmail: $result['bodyEmail'],
            id: $result['_id']);

        return $template;
    }

    /**
     * @param string $pk
     * @return bool
     * @throws NotFoundException
     */
    public function removeByPk(string $pk): bool
    {
        $collection = $this->mongoDBAdapter->mongodbDatabase->selectCollection('email-templates');

        $result = $collection->updateOne(['_id' => new ObjectId($pk)], ['$set' => [
            'deleted_at' => (string)Carbon::now()
        ]]);

        if ($result->getModifiedCount() == 0) {
            throw new NotFoundException( $this->translator->trans('messages.templateNotFound'),ErrorCode::SERVER_NOT_FOUND);
        }

        return true;
    }

    /**
     * @param EmailTemplateDTO $emailTemplateDTO
     * @return bool
     * @throws NotFoundException
     * @throws NothingToUpdateException
     */
    public function updateTemplate(EmailTemplateDTO $emailTemplateDTO): bool
    {
        $collection = $this->mongoDBAdapter->mongodbDatabase->selectCollection('email-templates');

        $result = $collection->findOne(['_id' => new ObjectId($emailTemplateDTO->id), 'deleted_at' => null]);

        if ($result == null) {
            throw new NotFoundException($this->translator->trans('messages.templateNotFound'), ErrorCode::SERVER_NOT_FOUND);
        }

        $template = EmailTemplate::createFromArray([
            'bodyEmail' => $result->bodyEmail,
            'templateName' => $result->templateName,
            'senderName' => $result->senderName,
            'senderEmail' => $result->senderEmail,
            'serviceId' => $result->serviceId,
            'id' => $result->_id
        ]);

        $template->setBodyEmail($emailTemplateDTO->bodyEmail);
        $template->setTemplateName($emailTemplateDTO->templateName);
        $template->setSenderName($emailTemplateDTO->senderName);
        $template->setSenderEmail($emailTemplateDTO->senderEmail);
        $template->setServiceId($emailTemplateDTO->serviceId);

        $result = $collection->updateOne(['_id' => new ObjectId($template->getId())],
            ['$set' => [
                'bodyEmail' => $template->getBodyEmail(),
                'templateName' => $template->getTemplateName(),
                'senderName' => $template->getSenderName(),
                'senderEmail' => $template->getSenderEmail(),
                'serviceId' => $template->getServiceId()
            ]]);

        if ($result->getModifiedCount() == 0) {
            throw new NothingToUpdateException($this->translator->trans('messages.nothingToUpdate'), ErrorCode::SERVER_ERROR);
        }

        return true;
    }
}
