<?php

namespace Application\Repository;

use Adapters\Interfaces\RabbitMQAdapterInterface;
use Adapters\Interfaces\UnisenderAdapterInterface;
use Adapters\RabbitMQAdapter;
use Adapters\UnisenderAdapter;
use Application\DTO\Notification\Email\NotificationToEmailDTO;
use Application\DTO\Notification\Email\OutputNotificationToEmailDTO;
use Application\DTO\Notification\Sms\NotificationToSmsDTO;
use Application\DTO\Notification\Sms\InputNotificationToSmsDTO;
use Application\DTO\Notification\Sms\OutputNotificationToSmsDTO;
use Application\DTO\WebSocketNotification\WebSocketNotificationDTO;
use Application\UseCase\ServiceSettings\GetByAuthKeyServiceSettings;
use Application\UseCase\SmsTemplate\GetByPkSmsTemplates;
use Common\Constants\ErrorCode;
use Common\Exception\BusinessException;
use Domain\NotificationRepositoryInterface;
use Domain\SmsTemplateRepositoryInterface;
use Hyperf\Context\ApplicationContext;
use Hyperf\Di\Annotation\Inject;
use Hyperf\Server\ServerFactory;

class NotificationRepository implements NotificationRepositoryInterface
{
    #[Inject]
    private UnisenderAdapterInterface $unisenderAdapter;

    #[Inject]
    private RabbitMQAdapterInterface $rabbitMQAdapter;


    public function saveEmail(NotificationToEmailDTO $notification): bool
    {
        $this->rabbitMQAdapter->pushToEmail($notification);

        return true;
    }

    public function pushToEmail(NotificationToEmailDTO $notification): void
    {
        $outputNotificationToEmail = new OutputNotificationToEmailDTO(
            api_key: $notification->apiKey,
            email: $notification->email,
            sender_email: $notification->senderEmail,
            sender_name: $notification->senderName,
            subject: $notification->subject,
            body: $notification->body,
            list_id: '1'
        );

        $this->unisenderAdapter->sendEmail($outputNotificationToEmail);
    }

    public function saveSms(NotificationToSmsDTO $notification): bool
    {
        $this->rabbitMQAdapter->pushToSms($notification);

        return true;
    }

    public function pushToSMS(NotificationToSmsDTO $notification): void
    {
        $outputNotificationToSms = new OutputNotificationToSmsDTO(
            api_key: $notification->apiKey,
            phone: $notification->phone,
            sender: $notification->sender,
            text: $notification->text
        );

        $this->unisenderAdapter->sendSms($outputNotificationToSms);
    }

    public function pushToWebSocketNotification(int $userIdWs, WebSocketNotificationDTO $notification): void
    {
        $container = ApplicationContext::getContainer();

        $server=$container->get(ServerFactory::class)->getServer()->getServer();

        $server->push($userIdWs, json_encode($notification));
    }

    public function saveWebSocketNotification(WebSocketNotificationDTO $notification): bool
    {
        $this->rabbitMQAdapter->pushToWebSocket($notification);

        return true;
    }
}