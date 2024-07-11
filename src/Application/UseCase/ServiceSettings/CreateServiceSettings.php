<?php

namespace Application\UseCase\ServiceSettings;

use Application\DTO\ServiceSettings\ServiceSettingsDTO;
use Application\Exception\ValidationFailedException;
use Common\Constants\ErrorCode;
use Common\Exception\BusinessException;
use Domain\ServiceSettingsRepositoryInterface;
use Hyperf\Di\Annotation\Inject;
use Hyperf\Validation\Contract\ValidatorFactoryInterface;

class CreateServiceSettings
{
    #[Inject]
    protected ValidatorFactoryInterface $validationFactory;
    private ServiceSettingsRepositoryInterface $serviceRepository;

    public function __construct(ServiceSettingsRepositoryInterface $serviceRepository)
    {
        $this->serviceRepository = $serviceRepository;
    }


    /**
     * @param ServiceSettingsDTO $companyServiceDTO
     * @return string
     * @throws ValidationFailedException
     */
    public function execute(ServiceSettingsDTO $companyServiceDTO): string
    {
        $validator = $this->validationFactory->make(
            $companyServiceDTO->getArray(),
            [
                'name' => 'required|string',
                'serviceType' => 'required|string',
                'serviceApiKey' => 'required|string'
            ],
            [
                'name.required' => 'name is required',
                'name.uuid' => 'name is string',
                'serviceType.required' => 'serviceType is required',
                'serviceType.string' => 'serviceType is string',
                'serviceApiKey.required' => 'serviceApiKey is required',
                'serviceApiKey.string' => 'serviceApiKey is string',
            ]
        );

        if ($validator->fails()) {
            throw new ValidationFailedException( $validator->errors(),ErrorCode::INVALID_REQUEST);
        }

        return $this->serviceRepository->create($companyServiceDTO);
    }
}