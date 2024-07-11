<?php

namespace Adapters;

use Adapters\Interfaces\UnisenderAdapterInterface;
use Application\DTO\Notification\Email\OutputNotificationToEmailDTO;
use Application\DTO\Notification\Sms\NotificationToSmsDTO;
use Application\DTO\Notification\Sms\OutputNotificationToSmsDTO;
use Hoa\Stream\IStream\Out;

class UnisenderAdapter implements UnisenderAdapterInterface
{
    private string $urlUnisender;

    public function __construct()
    {
        $this->urlUnisender = env('UNISENDER_ENV');
    }

    public function sendEmail(OutputNotificationToEmailDTO $notification): void
    {
        $options = [
            'http' => [
                'method' => 'POST',
                'header' => 'Content-type: application/x-www-form-urlencoded',
                'content' => http_build_query($notification->getArray()),
            ],
            'ssl' => [
                'crypto_method' => STREAM_CRYPTO_METHOD_TLSv1_2_CLIENT,
            ]
        ];
        \Swoole\Runtime::setHookFlags(SWOOLE_HOOK_ALL ^ SWOOLE_HOOK_CURL ^ SWOOLE_HOOK_NATIVE_CURL);

        $context = stream_context_create($options);

        $result = file_get_contents($this->urlUnisender . '/sendEmail?', false, $context);
    }

    public function sendSms(OutputNotificationToSmsDTO $notification): void
    {
        $options = [
            'http' => [
                'method' => 'POST',
                'header' => 'Content-type: application/x-www-form-urlencoded',
                'content' => http_build_query($notification->getArray()),
            ],
            'ssl' => [
                'crypto_method' => STREAM_CRYPTO_METHOD_TLSv1_2_CLIENT,
            ]
        ];
        \Swoole\Runtime::setHookFlags(SWOOLE_HOOK_ALL ^ SWOOLE_HOOK_CURL ^ SWOOLE_HOOK_NATIVE_CURL);

        $context = stream_context_create($options);

        $result = file_get_contents($this->urlUnisender . '/sendSms?', false, $context);

        var_dump($result);
    }
}