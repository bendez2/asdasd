<?php

namespace Application\UseCase\EmailTemplate;

use Application\DTO\EmailTemplate\CreateCompanyEmailTemplateDTO;
use Application\DTO\EmailTemplate\EmailTemplateDTO;
use Application\Exception\ValidationFailedException;
use Common\Constants\ErrorCode;
use Common\Exception\BusinessException;
use Domain\EmailTemplateRepositoryInterface;
use Hyperf\Di\Annotation\Inject;
use Hyperf\Validation\Contract\ValidatorFactoryInterface;

class CreateEmailTemplate
{
    #[Inject]
    protected ValidatorFactoryInterface $validationFactory;
    private EmailTemplateRepositoryInterface $emailTemplateRepository;

    public function __construct(EmailTemplateRepositoryInterface $emailTemplateRepository)
    {
        $this->emailTemplateRepository = $emailTemplateRepository;
    }


    /**
     * @param EmailTemplateDTO $emailTemplateDTO
     * @return bool
     * @throws ValidationFailedException
     */
    public function execute(EmailTemplateDTO $emailTemplateDTO): bool
    {
        $validator = $this->validationFactory->make(
            $emailTemplateDTO->getArray(),
            [
                'serviceId' => 'required|string',
                'templateName' => 'required|string',
                'senderName' => 'required|string',
                'senderEmail' => 'required|string',
                'bodyEmail' => 'required|string'
            ],
            [
                'serviceId.required' => 'serviceId is required',
                'serviceId.uuid' => 'serviceId is string',
                'templateName.required' => 'templateName is required',
                'templateName.string' => 'templateName is string',
                'senderName.required' => 'senderName is required',
                'senderName.string' => 'senderName is string',
                'senderEmail.required' => 'senderEmail is required',
                'senderEmail.string' => 'senderEmail is string',
                'bodyEmail.required' => 'bodyEmail is required',
                'bodyEmail.string' => 'bodyEmail is string',
            ]
        );

        if ($validator->fails()) {
            throw new ValidationFailedException( $validator->errors(),ErrorCode::INVALID_REQUEST);
        }

        return $this->emailTemplateRepository->create($emailTemplateDTO);
    }
}