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



use Application\DTO\SmsTemplate\SmsTemplateDTO;
use Application\UseCase\SmsTemplate\GetAllByServiceIdSmsTemplates;
use Application\UseCase\SmsTemplate\GetByPkSmsTemplates;
use Application\UseCase\SmsTemplate\RemoveByPkSmsTemplate;
use Application\UseCase\SmsTemplate\UpdateTemplateSmsTemplate;
use Common\MessageKeys;
use Domain\SmsTemplateRepositoryInterface;
use Hyperf\Context\ApplicationContext;
use Hyperf\Contract\TranslatorInterface;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;

class SmsTemplateController extends AbstractController
{
    #[Inject]
    private TranslatorInterface $translator;

    public function create(RequestInterface $request, ResponseInterface $response): \Psr\Http\Message\ResponseInterface
    {
        if (!$request->has(['sender', 'text', 'serviceId','name'])) {
            return $response->json([MessageKeys::MESSAGE_KEY_ERROR => $this->translator->trans('messages.errorRequest')])->withStatus(400);
        }

        try {
            $smsTemplateDTO = new SmsTemplateDTO(
                sender: $request->input('sender'),
                text: $request->input('text'),
                serviceId: $request->input('serviceId'),
                name: $request->input('name')
            );

            $container = ApplicationContext::getContainer();
            $repository = $container->get(SmsTemplateRepositoryInterface::class);

            $result = (new CreateSmsTemplate($repository))->execute($smsTemplateDTO);

            return $response->json([MessageKeys::MESSAGE_KEY_SUCCESS => $result])->withStatus(201);
        } catch (\Exception $exception) {
            return $response->json([MessageKeys::MESSAGE_KEY_ERROR => $exception->getMessage()])->withStatus($exception->getCode());
        }
    }

    public function getAllByServiceId(string $serviceId, ResponseInterface $response): \Psr\Http\Message\ResponseInterface
    {
        try {
            $container = ApplicationContext::getContainer();
            $repository = $container->get(SmsTemplateRepositoryInterface::class);

            $result = (new GetAllByServiceIdSmsTemplates($repository))->execute($serviceId);

            return $response->json([MessageKeys::MESSAGE_KEY_SUCCESS => $result])->withStatus(200);
        } catch (\Exception $exception) {
            return $response->json([MessageKeys::MESSAGE_KEY_ERROR => $exception->getMessage()])->withStatus($exception->getCode());
        }
    }

    public function getByPk(string $pk, ResponseInterface $response): \Psr\Http\Message\ResponseInterface
    {
        try {
            $container = ApplicationContext::getContainer();
            $repository = $container->get(SmsTemplateRepositoryInterface::class);

            $result = (new GetByPkSmsTemplates($repository))->execute($pk);

            return $response->json([MessageKeys::MESSAGE_KEY_SUCCESS => $result])->withStatus(200);
        } catch (\Exception $exception) {
            return $response->json([MessageKeys::MESSAGE_KEY_ERROR => $exception->getMessage()])->withStatus($exception->getCode());
        }
    }

    public function updateTemplate(RequestInterface $request, ResponseInterface $response): \Psr\Http\Message\ResponseInterface
    {
        if (!$request->has(['sender', 'text', 'serviceId','id', 'name'])) {
            return $response->json([MessageKeys::MESSAGE_KEY_ERROR => $this->translator->trans('messages.errorRequest')])->withStatus(400);
        }

        try {
            $template = new SmsTemplateDTO(
                sender: $request->input('sender'),
                text: $request->input('text'),
                serviceId: $request->input('serviceId'),
                name: $request->input('name'),
                id: $request->input('id')
            );

            $container = ApplicationContext::getContainer();
            $repository = $container->get(SmsTemplateRepositoryInterface::class);

            $result = (new UpdateTemplateSmsTemplate($repository))->execute($template);

            return $response->json([MessageKeys::MESSAGE_KEY_SUCCESS => $result])->withStatus(200);
        } catch (\Exception $exception) {
            return $response->json([MessageKeys::MESSAGE_KEY_ERROR => $exception->getMessage()])->withStatus($exception->getCode());
        }
    }
    public function removeByPk(string $pk, ResponseInterface $response): \Psr\Http\Message\ResponseInterface
    {
        try {
            $container = ApplicationContext::getContainer();
            $repository = $container->get(SmsTemplateRepositoryInterface::class);

            $result = (new RemoveByPkSmsTemplate($repository))->execute($pk);

            return $response->json([MessageKeys::MESSAGE_KEY_SUCCESS => $result])->withStatus(200);
        } catch (\Exception $exception) {
            return $response->json([MessageKeys::MESSAGE_KEY_ERROR => $exception->getMessage()])->withStatus($exception->getCode());
        }
    }
}
