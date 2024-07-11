<?php

namespace Application\UseCase\Notification\Save;

use Application\DTO\Notification\Email\InputNotificationToEmailDTO;
use Application\DTO\Notification\Email\NotificationToEmailDTO;
use Application\Exception\NotFoundException;
use Application\Exception\Notification\NotFoundTemplateException;
use Application\Exception\Notification\NotValidAuthKeyException;
use Application\Repository\ServiceSettingsRepository;
use Application\UseCase\EmailTemplate\GetByPkEmailTemplate;
use Application\UseCase\ServiceSettings\GetByAuthKeyServiceSettings;
use Common\Constants\ErrorCode;
use Domain\EmailTemplateRepositoryInterface;
use Domain\NotificationRepositoryInterface;
use Hyperf\Context\ApplicationContext;
use Hyperf\Contract\TranslatorInterface;
use Hyperf\Di\Annotation\Inject;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class SaveEmailNotification
{
    private NotificationRepositoryInterface $notificationRepository;

    #[Inject]
    private TranslatorInterface $translator;

    public function __construct(NotificationRepositoryInterface $notificationRepository)
    {
        $this->notificationRepository = $notificationRepository;
    }

    /**
     * @param InputNotificationToEmailDTO $notification
     * @return bool
     * @throws NotFoundTemplateException
     * @throws NotValidAuthKeyException
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function execute(InputNotificationToEmailDTO $notification): bool
    {
        $container = ApplicationContext::getContainer();
        $repository = $container->get(ServiceSettingsRepository::class);

        $settingsService = null;
        try {
            $settingsService = (new GetByAuthKeyServiceSettings($repository))->execute($notification->authKey);
        } catch (NotFoundException $exception) {
            throw new NotValidAuthKeyException($this->translator->trans('messages.errorAuthKeyNotFound'), ErrorCode::SERVER_NOT_FOUND);
        }

        $repository = $container->get(EmailTemplateRepositoryInterface::class);
        $template = null;
        try {
            $template = (new GetByPkEmailTemplate($repository))->execute($notification->templateId);
        } catch (NotFoundException $exception) {
            throw new NotFoundTemplateException($this->translator->trans('messages.errorTemplateNotFound'), ErrorCode::SERVER_NOT_FOUND);
        }

        $sentNotification = new NotificationToEmailDTO(
            apiKey: $settingsService->serviceApiKey,
            email: $notification->employeeEmail,
            senderEmail: $template->senderEmail,
            senderName: $template->senderName,
            subject: $template->templateName,
            body: $template->bodyEmail
        );

        foreach ($notification->preload as $preload) {
            $nameValue = array_keys($notification->preload, $preload);

            $sentNotification->body = str_replace('{{' . $nameValue[0] . '}}', $preload, $sentNotification->body);
        }

        $this->notificationRepository->saveEmail($sentNotification);

        return true;

    }
}