<?php

namespace Adapters;

use Adapters\Interfaces\RabbitMQAdapterInterface;
use Application\DTO\Notification\Email\NotificationToEmailDTO;
use Application\DTO\Notification\Sms\NotificationToSmsDTO;
use Application\DTO\WebSocketNotification\WebSocketNotificationDTO;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitMQAdapter implements RabbitMQAdapterInterface
{
    private AMQPStreamConnection $connection;
    public AMQPChannel $channel;

    public function __construct()
    {
        $this->connection = new AMQPStreamConnection(
            host: env('RABBITMQ_HOST'),
            port: env('RABBITMQ_PORT'),
            user: env('RABBITMQ_USER'),
            password: env('RABBITMQ_PASSWORD'));
        $this->channel = $this->connection->channel();
    }

    public function pushToEmail(NotificationToEmailDTO $notificationToEmailDTO): void
    {
        $jsonString = json_encode($notificationToEmailDTO);

        $message = new AMQPMessage($jsonString, ['delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT]);
        $this->channel->basic_publish($message,'','email');
    }

    public function pushToSms(NotificationToSmsDTO $notificationToSmsDTO): void
    {
        $jsonString = json_encode($notificationToSmsDTO);

        $message = new AMQPMessage($jsonString, ['delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT]);
        $this->channel->basic_publish($message,'','sms');
    }

    public function pushToWebSocket(WebSocketNotificationDTO $webSocketNotificationDTO): void
    {
        $jsonString = json_encode($webSocketNotificationDTO);

        $message = new AMQPMessage($jsonString, ['delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT]);
        $this->channel->basic_publish($message,'','websocket');
    }

}