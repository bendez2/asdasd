<?php

namespace Application\UseCase\EmailTemplate;

use Application\DTO\EmailTemplate\EmailTemplateDTO;
use Application\Exception\ValidationFailedException;
use Common\Constants\ErrorCode;
use Common\Exception\BusinessException;
use Domain\EmailTemplateRepositoryInterface;
use Hyperf\Di\Annotation\Inject;
use Hyperf\Validation\Contract\ValidatorFactoryInterface;

class UpdateEmailTemplate
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
                'id' => 'required|string',
                'serviceId' => 'required|string',
                'templateName' => 'required|string',
                'senderName' => 'required|string',
                'senderEmail' => 'required|string',
                'bodyEmail' => 'required|string'
            ],
            [
                'serviceId.required' => 'serviceId is required',
                'serviceId.string' => 'serviceId is string',
                'id.required' => 'id is required',
                'id.string' => 'id is string',
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
            throw new ValidationFailedException(message: $validator->errors(), code: ErrorCode::INVALID_REQUEST);
        }

        return $this->emailTemplateRepository->updateTemplate($emailTemplateDTO);
    }
}