<?php

namespace Application\UseCase\ServiceSettings;

use Application\DTO\ServiceSettings\ServiceSettingsDTO;
use Application\Exception\ValidationFailedException;
use Common\Constants\ErrorCode;
use Common\Exception\BusinessException;
use Domain\ServiceSettingsRepositoryInterface;
use Hyperf\Di\Annotation\Inject;
use Hyperf\Validation\Contract\ValidatorFactoryInterface;

class UpdateByAuthKeyServiceSettings
{
    #[Inject]
    protected ValidatorFactoryInterface $validationFactory;
    private ServiceSettingsRepositoryInterface $serviceRepository;

    public function __construct(ServiceSettingsRepositoryInterface $serviceRepository)
    {
        $this->serviceRepository = $serviceRepository;
    }


    /**
     * @param ServiceSettingsDTO $serviceSettingsDTO
     * @return bool
     * @throws ValidationFailedException
     */
    public function execute(ServiceSettingsDTO $serviceSettingsDTO): bool
    {
        $validator = $this->validationFactory->make(
            $serviceSettingsDTO->getArray(),
            [
                'name' => 'required|string',
                'serviceType' => 'required|string',
                'serviceApiKey' => 'required|string',
                'authKey' => 'required|string',
            ],
            [
                'name.required' => 'name is required',
                'name.uuid' => 'name is string',
                'serviceType.required' => 'serviceType is required',
                'serviceType.string' => 'serviceType is string',
                'serviceApiKey.required' => 'serviceApiKey is required',
                'serviceApiKey.string' => 'serviceApiKey is string',
                'authKey.required' => 'authKey is required',
                'authKey.string' => 'authKey is string'
            ]
        );

        if ($validator->fails()) {
            throw new ValidationFailedException($validator->errors(),ErrorCode::INVALID_REQUEST);
        }

        return $this->serviceRepository->updateByAuthKey($serviceSettingsDTO);
    }
}