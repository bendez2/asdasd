<?php

namespace Adapters\Interfaces;

use Application\DTO\Notification\Email\OutputNotificationToEmailDTO;
use Application\DTO\Notification\Sms\NotificationToSmsDTO;
use Application\DTO\Notification\Sms\OutputNotificationToSmsDTO;

interface UnisenderAdapterInterface
{
    public function sendEmail(OutputNotificationToEmailDTO $notification): void;

    public function sendSms(OutputNotificationToSmsDTO $notification): void;
}