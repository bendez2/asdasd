<?php

namespace Adapters\Consumers;


use Application\DTO\Notification\Sms\InputNotificationToSmsDTO;
use Application\DTO\Notification\Sms\NotificationToSmsDTO;
use Application\UseCase\Notification\Push\PushToSmsNotification;
use Domain\NotificationRepositoryInterface;
use Hyperf\Amqp\Annotation\Consumer;
use Hyperf\Amqp\Message\ConsumerMessage;
use Hyperf\Amqp\Result;
use Hyperf\Context\ApplicationContext;
use PhpAmqpLib\Message\AMQPMessage;


#[Consumer(exchange: 'sms', routingKey: '', queue: 'sms', nums: 1)]
class SMSConsumer extends ConsumerMessage
{
    public function consumeMessage($data, AMQPMessage $message): Result
    {
        $notification = new NotificationToSmsDTO(
            apiKey: $data['apiKey'],
            phone: $data['phone'],
            sender: $data['sender'],
            text: $data['text']
        );

        $container = ApplicationContext::getContainer();
        $repository = $container->get(NotificationRepositoryInterface::class);

        (new PushToSmsNotification($repository))->execute($notification);

        return Result::ACK;
    }

}