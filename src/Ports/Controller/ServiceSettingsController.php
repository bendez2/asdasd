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


use Application\DTO\ServiceSettings\ServiceSettingsDTO;
use Application\UseCase\ServiceSettings\CreateServiceSettings;
use Application\UseCase\ServiceSettings\GetByAuthKeyServiceSettings;
use Application\UseCase\ServiceSettings\RemoveByAuthKeyServiceSettings;
use Application\UseCase\ServiceSettings\UpdateByAuthKeyServiceSettings;
use Common\MessageKeys;
use Domain\ServiceSettingsRepositoryInterface;
use Hyperf\Context\ApplicationContext;
use Hyperf\Contract\TranslatorInterface;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;

class ServiceSettingsController extends AbstractController
{
    #[Inject]
    private TranslatorInterface $translator;

    public function create(RequestInterface $request, ResponseInterface $response): \Psr\Http\Message\ResponseInterface
    {
        if (!$request->has(['serviceApiKey', 'serviceType', 'name'])) {
            return $response->json([MessageKeys::MESSAGE_KEY_ERROR => $this->translator->trans('messages.errorRequest')])->withStatus(400);
        }

        try {
            $serviceSettingsDTO = new ServiceSettingsDTO(
                serviceApiKey: $request->input('serviceApiKey'),
                serviceType: $request->input('serviceType'),
                name: $request->input('name'),
            );

            $container = ApplicationContext::getContainer();
            $repository = $container->get(ServiceSettingsRepositoryInterface::class);

            $result = (new CreateServiceSettings($repository))->execute($serviceSettingsDTO);

            return $response->json([MessageKeys::MESSAGE_KEY_SUCCESS => ['authKey' => $result]])->withStatus(201);
        } catch (\Exception $exception) {
            return $response->json([MessageKeys::MESSAGE_KEY_ERROR => $exception->getMessage()])->withStatus($exception->getCode());
        }
    }

    public function getByAuthKey(string $authKey, ResponseInterface $response): \Psr\Http\Message\ResponseInterface
    {
        try {
            $container = ApplicationContext::getContainer();
            $repository = $container->get(ServiceSettingsRepositoryInterface::class);

            $result = (new GetByAuthKeyServiceSettings($repository))->execute($authKey);

            return $response->json([MessageKeys::MESSAGE_KEY_SUCCESS => $result])->withStatus(200);
        } catch (\Exception $exception) {
            return $response->json([MessageKeys::MESSAGE_KEY_ERROR => $exception->getMessage()])->withStatus($exception->getCode());
        }
    }

    public function updateByAuthKey(RequestInterface $request, ResponseInterface $response): \Psr\Http\Message\ResponseInterface
    {
        if (!$request->has(['authKey', 'serviceType', 'serviceApiKey', 'name'])) {
            return $response->json([MessageKeys::MESSAGE_KEY_ERROR => $this->translator->trans('messages.errorRequest')])->withStatus(400);
        }

        try {
            $serviceSettings = new ServiceSettingsDTO(
                serviceApiKey: $request->input('serviceApiKey'),
                serviceType: $request->input('serviceType'),
                name: $request->input('name'),
                id: null,
                authKey: $request->input('authKey')
            );

            $container = ApplicationContext::getContainer();
            $repository = $container->get(ServiceSettingsRepositoryInterface::class);

            $result = (new UpdateByAuthKeyServiceSettings($repository))->execute($serviceSettings);

            return $response->json([MessageKeys::MESSAGE_KEY_SUCCESS => $result])->withStatus(200);
        } catch (\Exception $exception) {
            return $response->json([MessageKeys::MESSAGE_KEY_ERROR => $exception->getMessage()])->withStatus($exception->getCode());
        }
    }

    public function removeByAuthKey(string $authKey, ResponseInterface $response): \Psr\Http\Message\ResponseInterface
    {
        try {
            $container = ApplicationContext::getContainer();
            $repository = $container->get(ServiceSettingsRepositoryInterface::class);

            $result = (new RemoveByAuthKeyServiceSettings($repository))->execute($authKey);

            return $response->json([MessageKeys::MESSAGE_KEY_SUCCESS => $result])->withStatus(200);
        } catch (\Exception $exception) {
            return $response->json([MessageKeys::MESSAGE_KEY_ERROR => $exception->getMessage()])->withStatus($exception->getCode());
        }
    }
}
