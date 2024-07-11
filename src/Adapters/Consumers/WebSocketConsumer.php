<?php

namespace Adapters\Consumers;


use Application\DTO\WebSocketNotification\WebSocketNotificationDTO;
use Application\UseCase\Notification\Push\PushToWebSocketNotification;
use Hyperf\Amqp\Annotation\Consumer;
use Hyperf\Amqp\Message\ConsumerMessage;
use Hyperf\Amqp\Result;
use PhpAmqpLib\Message\AMQPMessage;


#[Consumer(exchange: 'websocket', routingKey: '', queue: 'websocket', nums: 1)]
class WebSocketConsumer extends ConsumerMessage
{
    public function consumeMessage($data, AMQPMessage $message): Result
    {
        $notification = new WebSocketNotificationDTO(
            userId: $data['userId'],
            applicationId: $data['applicationId'],
            message: $data['message']
        );

        (new PushToWebSocketNotification())->execute($notification);

        return Result::ACK;
    }

}