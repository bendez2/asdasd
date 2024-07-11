<?php

declare(strict_types=1);

/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */

use Adapters\Interfaces\MongoDBAdapterInterface;
use Adapters\Interfaces\RabbitMQAdapterInterface;
use Adapters\Interfaces\UnisenderAdapterInterface;
use Adapters\MongoDBAdapter;
use Adapters\RabbitMQAdapter;
use Adapters\UnisenderAdapter;
use Application\Repository\EmailTemplateRepository;
use Application\Repository\NotificationRepository;
use Application\Repository\ServiceSettingsRepository;
use Application\Repository\SmsTemplateRepository;
use Application\Repository\WebSocketNotificationRepository;
use Application\Repository\WebSocketUserRepository;
use Domain\ServiceSettingsRepositoryInterface;
use Domain\EmailTemplateRepositoryInterface;
use Domain\SmsTemplateRepositoryInterface;
use Domain\NotificationRepositoryInterface;
use Domain\WebSocketNotificationRepositoryInterface;
use Domain\WebSocketUserRepositoryInterface;

return [
    WebSocketUserRepositoryInterface::class => WebSocketUserRepository::class,
    SmsTemplateRepositoryInterface::class => SmsTemplateRepository::class,
    WebSocketNotificationRepositoryInterface::class => WebSocketNotificationRepository::class,
    EmailTemplateRepositoryInterface::class => EmailTemplateRepository::class,
    ServiceSettingsRepositoryInterface::class => ServiceSettingsRepository::class,
    NotificationRepositoryInterface::class => NotificationRepository::class,
    MongoDBAdapterInterface::class => MongoDBAdapter::class,
    RabbitMqAdapterInterface::class => RabbitMqAdapter::class,
    UnisenderAdapterInterface::class => UnisenderAdapter::class
];
