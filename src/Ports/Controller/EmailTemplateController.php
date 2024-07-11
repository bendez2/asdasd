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


use Application\DTO\EmailTemplate\EmailTemplateDTO;
use Application\UseCase\EmailTemplate\CreateEmailTemplate;
use Application\UseCase\EmailTemplate\GetAllByServiceIdEmailTemplates;
use Application\UseCase\EmailTemplate\GetByPkEmailTemplate;
use Application\UseCase\EmailTemplate\RemoveByPkEmailTemplate;
use Application\UseCase\EmailTemplate\UpdateEmailTemplate;
use Common\MessageKeys;
use Domain\EmailTemplateRepositoryInterface;
use Hyperf\Context\ApplicationContext;
use Hyperf\Contract\TranslatorInterface;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;

class EmailTemplateController extends AbstractController
{
    #[Inject]
    private TranslatorInterface $translator;

    public function create(RequestInterface $request, ResponseInterface $response): \Psr\Http\Message\ResponseInterface
    {
        if (!$request->has(['serviceId', 'templateName', 'senderName', 'senderEmail', 'bodyEmail'])) {
            return $response->json([MessageKeys::MESSAGE_KEY_ERROR => $this->translator->trans('messages.errorRequest')])->withStatus(400);
        }

        try {
            $newEmailTemplate = new EmailTemplateDTO(
                serviceId: $request->input('serviceId'),
                templateName: $request->input('templateName'),
                senderName: $request->input('senderName'),
                senderEmail: $request->input('senderEmail'),
                bodyEmail: $request->input('bodyEmail'),
            );

            $container = ApplicationContext::getContainer();
            $repository = $container->get(EmailTemplateRepositoryInterface::class);

            $result = (new CreateEmailTemplate($repository))->execute($newEmailTemplate);

            return $response->json([MessageKeys::MESSAGE_KEY_SUCCESS => $result])->withStatus(201);
        } catch (\Exception $exception) {
            return $response->json([MessageKeys::MESSAGE_KEY_ERROR => $exception->getMessage()])->withStatus($exception->getCode());
        }
    }

    public function getAllByServiceId(string $serviceId, ResponseInterface $response): \Psr\Http\Message\ResponseInterface
    {
        try {
            $container = ApplicationContext::getContainer();
            $repository = $container->get(EmailTemplateRepositoryInterface::class);

            $result = (new GetAllByServiceIdEmailTemplates($repository))->execute($serviceId);

            return $response->json([MessageKeys::MESSAGE_KEY_SUCCESS => $result])->withStatus(200);
        } catch (\Exception $exception) {
            return $response->json([MessageKeys::MESSAGE_KEY_ERROR => $exception->getMessage()])->withStatus($exception->getCode());
        }
    }

    public function getByPk(string $pk, ResponseInterface $response): \Psr\Http\Message\ResponseInterface
    {
        try {
            $container = ApplicationContext::getContainer();
            $repository = $container->get(EmailTemplateRepositoryInterface::class);

            $result = (new GetByPkEmailTemplate($repository))->execute($pk);

            return $response->json([MessageKeys::MESSAGE_KEY_SUCCESS => $result])->withStatus(200);
        } catch (\Exception $exception) {
            return $response->json([MessageKeys::MESSAGE_KEY_ERROR => $exception->getMessage()])->withStatus($exception->getCode());
        }
    }

    public function updateTemplate(RequestInterface $request, ResponseInterface $response): \Psr\Http\Message\ResponseInterface
    {
        if (!$request->has(['id', 'serviceId', 'templateName', 'senderName', 'senderEmail', 'bodyEmail'])) {
            return $response->json([MessageKeys::MESSAGE_KEY_ERROR => $this->translator->trans('messages.errorRequest')])->withStatus(400);
        }

        try {
            $emailTemplateDTO = new EmailTemplateDTO(
                serviceId: $request->input('serviceId'),
                templateName: $request->input('templateName'),
                senderName: $request->input('senderName'),
                senderEmail: $request->input('senderEmail'),
                bodyEmail: $request->input('bodyEmail'),
                id: $request->input('id'),
            );

            $container = ApplicationContext::getContainer();
            $repository = $container->get(EmailTemplateRepositoryInterface::class);

            $result = (new UpdateEmailTemplate($repository))->execute($emailTemplateDTO);

            return $response->json([MessageKeys::MESSAGE_KEY_SUCCESS => $result])->withStatus(200);
        } catch (\Exception $exception) {
            return $response->json([MessageKeys::MESSAGE_KEY_ERROR => $exception->getMessage()])->withStatus($exception->getCode());
        }
    }

    public function removeByPk(string $pk, ResponseInterface $response): \Psr\Http\Message\ResponseInterface
    {
        try {
            $container = ApplicationContext::getContainer();
            $repository = $container->get(EmailTemplateRepositoryInterface::class);

            $result = (new RemoveByPkEmailTemplate($repository))->execute($pk);

            return $response->json([MessageKeys::MESSAGE_KEY_SUCCESS => $result])->withStatus(200);
        } catch (\Exception $exception) {
            return $response->json([MessageKeys::MESSAGE_KEY_ERROR => $exception->getMessage()])->withStatus($exception->getCode());
        }
    }
}
