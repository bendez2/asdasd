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

namespace Ports\Controller;


use Application\DTO\Notification\Email\InputNotificationToEmailDTO;
use Application\DTO\Notification\Sms\InputNotificationToSmsDTO;
use Application\DTO\WebSocketNotification\WebSocketNotificationDTO;
use Application\UseCase\Notification\Save\SaveEmailNotification;
use Application\UseCase\Notification\Save\SaveSmsNotification;
use Application\UseCase\Notification\Save\SaveWebSocketNotificationUseCase;
use Common\MessageKeys;
use Domain\NotificationRepositoryInterface;
use Hyperf\Context\ApplicationContext;
use Hyperf\Contract\TranslatorInterface;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;

class NotificationController extends AbstractController
{
    #[Inject]
    private TranslatorInterface $translator;
    public function pushEmail(ResponseInterface $response, RequestInterface $request): \Psr\Http\Message\ResponseInterface
    {
        if (!$request->has([
            'authKey',
            'templateId',
            'employeeEmail',
            'preload'
        ])) {
            return $response->json([MessageKeys::MESSAGE_KEY_ERROR => $this->translator->trans('messages.errorRequest')])->withStatus(400);
        }

        try {
            $notification = new InputNotificationToEmailDTO(
                authKey: $request->input('authKey'),
                templateId: $request->input('templateId'),
                employeeEmail: $request->input('employeeEmail'),
                preload: $request->input('preload')
            );

            $container = ApplicationContext::getContainer();
            $repository = $container->get(NotificationRepositoryInterface::class);

            $result = (new SaveEmailNotification($repository))->execute($notification);

            return $response->json([MessageKeys::MESSAGE_KEY_SUCCESS => $result])->withStatus(200);
        } catch (\Exception $exception) {
            return $response->json([MessageKeys::MESSAGE_KEY_ERROR => $exception->getMessage()])->withStatus($exception->getCode());
        }
    }

    public function pushSms(ResponseInterface $response, RequestInterface $request): \Psr\Http\Message\ResponseInterface
    {
        if (!$request->has([
            'authKey',
            'templateId',
            'phone',
            'preload'
        ])) {
            return $response->json([MessageKeys::MESSAGE_KEY_ERROR => $this->translator->trans('messages.errorRequest')])->withStatus(400);
        }

        try {
            $notification = new InputNotificationToSmsDTO(
                authKey: $request->input('authKey'),
                templateId: $request->input('templateId'),
                phone: $request->input('phone'),
                preload: $request->input('preload')
            );

            $container = ApplicationContext::getContainer();
            $repository = $container->get(NotificationRepositoryInterface::class);

            $result = (new SaveSmsNotification($repository))->execute($notification);

            return $response->json([MessageKeys::MESSAGE_KEY_SUCCESS => $result])->withStatus(200);
        } catch (\Exception $exception) {
            return $response->json([MessageKeys::MESSAGE_KEY_ERROR => $exception->getMessage()])->withStatus($exception->getCode());
        }
    }

    public function pushWebSocket(ResponseInterface $response, RequestInterface $request): \Psr\Http\Message\ResponseInterface
    {
        if (!$request->has([
            'userId',
            'applicationId',
            'message'
        ])) {
            return $response->json([MessageKeys::MESSAGE_KEY_ERROR => $this->translator->trans('messages.errorRequest')])->withStatus(400);
        }

        try {
            $notification = new WebSocketNotificationDTO(
                userId: $request->input('userId'),
                applicationId: $request->input('applicationId'),
                message: $request->input('message')
            );

            $container = ApplicationContext::getContainer();
            $repository = $container->get(NotificationRepositoryInterface::class);

            $result = (new SaveWebSocketNotificationUseCase($repository))->execute($notification);

            return $response->json([MessageKeys::MESSAGE_KEY_SUCCESS => $result])->withStatus(200);
        } catch (\Exception $exception) {
            return $response->json([MessageKeys::MESSAGE_KEY_ERROR => $exception->getMessage()])->withStatus($exception->getCode());
        }
    }
}
