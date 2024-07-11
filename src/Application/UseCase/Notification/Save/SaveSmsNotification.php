<?php

namespace Application\UseCase\Notification\Save;

use Application\DTO\Notification\Email\NotificationToEmailDTO;
use Application\DTO\Notification\Sms\InputNotificationToSmsDTO;
use Application\DTO\Notification\Sms\NotificationToSmsDTO;
use Application\Repository\ServiceSettingsRepository;
use Application\UseCase\EmailTemplate\GetByPkEmailTemplate;
use Application\UseCase\ServiceSettings\GetByAuthKeyServiceSettings;
use Application\UseCase\SmsTemplate\GetByPkSmsTemplates;
use Domain\EmailTemplateRepositoryInterface;
use Domain\NotificationRepositoryInterface;
use Domain\SmsTemplateRepositoryInterface;
use Hyperf\Context\ApplicationContext;

class SaveSmsNotification
{
    private NotificationRepositoryInterface $notificationRepository;

    public function __construct(NotificationRepositoryInterface $notificationRepository)
    {
        $this->notificationRepository = $notificationRepository;
    }

    public function execute(InputNotificationToSmsDTO $notification): bool
    {
        try {
            $container = ApplicationContext::getContainer();
            $repository = $container->get(ServiceSettingsRepository::class);

            $settingsService = (new GetByAuthKeyServiceSettings($repository))->execute($notification->authKey);

            $repository = $container->get(SmsTemplateRepositoryInterface::class);
            $template = (new GetByPkSmsTemplates($repository))->execute($notification->templateId);

            $sentNotification = new NotificationToSmsDTO(
                apiKey: $settingsService->serviceApiKey,
                phone: $notification->phone,
                sender: $template->sender,
                text: $template->text
            );

            foreach ($notification->preload as $preload){
                $nameValue = array_keys($notification->preload,$preload);

                $sentNotification->text = str_replace('{{'.$nameValue[0].'}}',$preload , $sentNotification->text);
            }

            $this->notificationRepository->saveSms($sentNotification);

            return true;

        } catch (\Exception $e) {
            var_dump($e->getMessage());
        }
    }
}