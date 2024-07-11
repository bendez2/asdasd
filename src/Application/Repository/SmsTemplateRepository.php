<?php

namespace Application\Repository;

use Adapters\Interfaces\MongoDBAdapterInterface;
use Adapters\MongoDBAdapter;

use Application\DTO\SmsTemplate\AllCompanySmsTemplateDTO;
use Application\DTO\SmsTemplate\SmsTemplateDTO;
use Application\DTO\SmsTemplate\CreateCompanySmsTemplateDTO;
use Application\Exception\ErrorCreatingException;
use Application\Exception\NotFoundException;
use Application\Exception\NothingToUpdateException;
use Carbon\Carbon;
use Common\Constants\ErrorCode;
use Common\Exception\BusinessException;
use Domain\SmsTemplateRepositoryInterface;
use Domain\Entity\SmsTemplate;
use Hyperf\Contract\TranslatorInterface;
use Hyperf\Di\Annotation\Inject;
use MongoDB\BSON\ObjectId;


class SmsTemplateRepository implements SmsTemplateRepositoryInterface
{
    #[Inject]
    private TranslatorInterface $translator;
    #[Inject]
    private MongoDBAdapterInterface $mongoDBAdapter;

    /**
     * @param SmsTemplateDTO $smsTemplateDTO
     * @return bool
     * @throws ErrorCreatingException
     */
    public function create(SmsTemplateDTO $smsTemplateDTO): bool
    {
        $template = new SmsTemplate(
            $smsTemplateDTO->sender,
            $smsTemplateDTO->text,
            $smsTemplateDTO->serviceId,
            $smsTemplateDTO->name
        );


        $collections = $this->mongoDBAdapter->mongodbDatabase->selectCollection('sms-templates');

        $result = $collections->insertOne([
            'sender' => $template->getSender(),
            'text' => $template->getText(),
            'serviceId' => $template->getServiceId(),
            'name' => $template->getName(),
        ]);

        if ($result->getInsertedCount() == 0) {
            throw new ErrorCreatingException($this->translator->trans('messages.errorCreatedNewTemplate'), ErrorCode::SERVER_ERROR);
        }

        return true;
    }

    /**
     * @param string $serviceId
     * @return array
     */
    public function getAllByServiceId(string $serviceId): array
    {
        $collections = $this->mongoDBAdapter->mongodbDatabase->selectCollection('sms-templates');

        $result = $collections->find(['serviceId' => $serviceId, 'deleted_at' => null]);

        $templates = [];

        foreach ($result as $document) {
            $templates[] = new SmsTemplateDTO(
                sender: $document['sender'],
                text: $document['text'],
                serviceId: $document['serviceId'],
                name: $document['name'],
                id: $document['_id'],
            );
        }

        return $templates;
    }

    /**
     * @param string $pk
     * @return SmsTemplateDTO
     * @throws NotFoundException
     */
    public function getByPk(string $pk): SmsTemplateDTO
    {
        $collection = $this->mongoDBAdapter->mongodbDatabase->selectCollection('sms-templates');

        $result = $collection->findOne(['_id' => new ObjectId($pk), 'deleted_at' => null]);

        if ($result == null) {
            throw new NotFoundException($this->translator->trans('messages.notFound'), ErrorCode::SERVER_NOT_FOUND);
        }

        $template = new SmsTemplateDTO(
            sender: $result['sender'],
            text: $result['text'],
            serviceId: $result['serviceId'],
            name: $result['name'],
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
        $collection = $this->mongoDBAdapter->mongodbDatabase->selectCollection('sms-templates');

        $result = $collection->updateOne(['_id' => new ObjectId($pk)], ['$set' => [
            'deleted_at' => (string)Carbon::now()
        ]]);

        if ($result->getModifiedCount() == 0) {
            throw new NotFoundException($this->translator->trans('messages.notFound'), ErrorCode::SERVER_NOT_FOUND);
        }

        return true;
    }

    /**
     * @param SmsTemplateDTO $smsTemplateDTO
     * @return bool
     * @throws NotFoundException
     * @throws NothingToUpdateException
     */
    public function updateTemplate(SmsTemplateDTO $smsTemplateDTO): bool
    {
        $collection = $this->mongoDBAdapter->mongodbDatabase->selectCollection('sms-templates');

        $result = $collection->findOne(['_id' => new ObjectId($smsTemplateDTO->id), 'deleted_at' => null]);

        if ($result == null) {
            throw new NotFoundException($this->translator->trans('messages.notFound'), ErrorCode::SERVER_NOT_FOUND);
        }

        $template = SmsTemplate::createFromArray([
            'sender' => $result->sender,
            'text' => $result->text,
            'serviceId' => $result->serviceId,
            'name' => $result->name,
            'id' => $result->_id
        ]);

        $template->setSender($smsTemplateDTO->sender);
        $template->setText($smsTemplateDTO->text);
        $template->setServiceId($smsTemplateDTO->serviceId);
        $template->setName($smsTemplateDTO->name);

        $result = $collection->updateOne(['_id' => new ObjectId($template->getId())],
            ['$set' => [
                'sender' => $template->getSender(),
                'text' => $template->getText(),
                'serviceId' => $template->getServiceId(),
                'name' => $template->getName()
            ]]);

        if ($result->getModifiedCount() == 0) {
            throw new NothingToUpdateException($this->translator->trans('messages.nothingToUpdate'),ErrorCode::SERVER_ERROR);
        }

        return true;
    }
}
