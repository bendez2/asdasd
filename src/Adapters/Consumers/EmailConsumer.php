<?php

namespace Adapters\Consumers;


use Application\DTO\Notification\Email\NotificationToEmailDTO;
use Application\Repository\NotificationRepository;
use Application\UseCase\Notification\Push\PushToEmailNotification;
use Hyperf\Amqp\Annotation\Consumer;
use Hyperf\Amqp\Message\ConsumerMessage;
use Hyperf\Amqp\Result;
use Hyperf\Context\ApplicationContext;
use PhpAmqpLib\Message\AMQPMessage;


#[Consumer(exchange: 'email', routingKey: '', queue: 'email', nums: 1)]
class EmailConsumer extends ConsumerMessage
{
    public function consumeMessage($data, AMQPMessage $message): Result
    {
        $notification = new NotificationToEmailDTO(
            apiKey: $data['apiKey'],
            email: $data['email'],
            senderEmail: $data['senderEmail'],
            senderName: $data['senderName'],
            subject: $data['subject'],
            body: $data['body'],
            list_id: $data['list_id'],
        );

        $container = ApplicationContext::getContainer();
        $repository = $container->get(NotificationRepository::class);

        (new PushToEmailNotification($repository))->execute($notification);

        return Result::ACK;
    }

}