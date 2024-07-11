<?php

namespace Application\Repository;

use Adapters\Interfaces\MongoDBAdapterInterface;
use Application\DTO\ServiceSettings\ServiceSettingsDTO;
use Application\Exception\ErrorCreatingException;
use Application\Exception\NameIsAlreadyExistsException;
use Application\Exception\NotFoundException;
use Application\Exception\NothingToUpdateException;
use Carbon\Carbon;
use Common\Constants\ErrorCode;
use Common\Exception\BusinessException;
use Domain\ServiceSettingsRepositoryInterface;
use Domain\Entity\ServiceSettings;
use Hyperf\Contract\TranslatorInterface;
use Hyperf\Di\Annotation\Inject;

class ServiceSettingsRepository implements ServiceSettingsRepositoryInterface
{
    #[Inject]
    private TranslatorInterface $translator;
    #[Inject]
    private MongoDBAdapterInterface $mongoDBAdapter;

    /**
     * @param ServiceSettingsDTO $serviceSettingsDTO
     * @return string
     */
    public function create(ServiceSettingsDTO $serviceSettingsDTO): string
    {
        $collections = $this->mongoDBAdapter->mongodbDatabase->selectCollection('settings');

        $result = $collections->findOne(['name' => $serviceSettingsDTO->name]);

        if (!empty($result)) {
            throw new NameIsAlreadyExistsException($this->translator->trans('messages.nameIsAlreadyExists'), ErrorCode::SERVER_ERROR);
        }

        $serviceSettings = new ServiceSettings(
            name: $serviceSettingsDTO->name,
            serviceApiKey: $serviceSettingsDTO->serviceApiKey,
            serviceType: $serviceSettingsDTO->serviceType,
            id: $serviceSettingsDTO->id
        );


        $result = $collections->insertOne([
            'name' => $serviceSettings->getName(),
            'serviceType' => $serviceSettings->getServiceType(),
            'serviceApiKey' => $serviceSettings->getServiceApiKey(),
            'authKey' => $serviceSettings->getAuthKey()
        ]);

        if ($result->getInsertedCount() == 0) {
            throw new ErrorCreatingException($this->translator->trans('messages.errorWhenCreating'), ErrorCode::SERVER_ERROR);
        }

        return $serviceSettings->getAuthKey();
    }

    /**
     * @param string $authKey
     * @return bool
     * @throws NotFoundException
     */
    public function removeByAuthKey(string $authKey): bool
    {
        $collection = $this->mongoDBAdapter->mongodbDatabase->selectCollection('settings');

        $result = $collection->updateOne(['authKey' => $authKey], ['$set' => [
            'deleted_at' => (string)Carbon::now()
        ]]);

        if ($result->getModifiedCount() == 0) {
            throw new NotFoundException($this->translator->trans('messages.notFound'), ErrorCode::SERVER_NOT_FOUND,);
        }

        return true;
    }

    /**
     * @param string $authKey
     * @return ServiceSettingsDTO
     * @throws NotFoundException
     */
    public function getByAuthKey(string $authKey): ServiceSettingsDTO
    {
        $collections = $this->mongoDBAdapter->mongodbDatabase->selectCollection('settings');

        $result = $collections->findOne(['authKey' => $authKey, 'deleted_at' => null]);

        if ($result == null) {
            throw new NotFoundException($this->translator->trans('messages.notFound'), ErrorCode::SERVER_NOT_FOUND);
        }

        $settingsService = new ServiceSettingsDTO(
            serviceApiKey: $result['serviceApiKey'],
            serviceType: $result['serviceType'],
            name: $result['name'],
            id: $result['_id'],
            authKey: $result['authKey']
        );

        return $settingsService;
    }

    /**
     * @param ServiceSettingsDTO $serviceSettingsDTO
     * @return bool
     * @throws NotFoundException
     * @throws NothingToUpdateException
     */
    public function updateByAuthKey(ServiceSettingsDTO $serviceSettingsDTO): bool
    {
        $collection = $this->mongoDBAdapter->mongodbDatabase->selectCollection('settings');

        $result = $collection->findOne(['authKey' => $serviceSettingsDTO->authKey, 'deleted_at' => null]);

        if ($result == null) {
            throw new NotFoundException($this->translator->trans('messages.notFound'), ErrorCode::SERVER_NOT_FOUND);
        }

        $serviceSettings = ServiceSettings::createFromArray([
            'serviceApiKey' => $result->serviceApiKey,
            'serviceType' => $result->serviceType,
            'id' => $result->_id,
            'name' => $result->name
        ]);

        $serviceSettings->setName($serviceSettingsDTO->name);
        $serviceSettings->setServiceType($serviceSettingsDTO->serviceType);
        $serviceSettings->setServiceApiKey($serviceSettingsDTO->serviceApiKey);

        $result = $collection->updateOne(['authKey' => $serviceSettingsDTO->authKey, 'deleted_at' => null], ['$set' => [
            'serviceApiKey' => $serviceSettings->getServiceApiKey(),
            'serviceType' => $serviceSettings->getServiceType(),
            'name' => $serviceSettings->getName()
        ]]);

        if ($result->getModifiedCount() == 0) {
            throw new NothingToUpdateException($this->translator->trans('messages.nothingToUpdate'), ErrorCode::SERVER_NOT_FOUND);
        }

        return true;
    }
}
