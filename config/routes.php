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


use Hyperf\HttpServer\Router\Router;

Router::addServer('ws', function () {
    Router::get('/notification/ws', 'Ports\Controller\WebSocketController');
});


Router::get('/favicon.ico', function () {
    return '';
});

Router::addGroup('/api', function () {

    Router::get('ws/', function () {return " asd";});

    Router::addGroup('/notification', function () {
        Router::post('/email', 'Ports\Controller\NotificationController@pushEmail');
        Router::post('/sms', 'Ports\Controller\NotificationController@pushSms');
        Router::post('/ws', 'Ports\Controller\NotificationController@pushWebSocket');
    });

    Router::addGroup('/service', function () {
        Router::addGroup('/settings', function () {
            Router::post('/', 'Ports\Controller\ServiceSettingsController@create');
            Router::get('/{authKey}', 'Ports\Controller\ServiceSettingsController@getByAuthKey');
            Router::put('/', 'Ports\Controller\ServiceSettingsController@updateByAuthKey');
            Router::delete('/{authKey}', 'Ports\Controller\ServiceSettingsController@removeByAuthKey');
        });

        Router::addGroup('/email-template', function () {
            Router::addGroup('/service', function () {
                Router::get('/{serviceId}', 'Ports\Controller\EmailTemplateController@getAllByServiceId');
            });
            
            Router::get('/{pk}', 'Ports\Controller\EmailTemplateController@getByPk');
            Router::post('/', 'Ports\Controller\EmailTemplateController@create');
            Router::put('/', 'Ports\Controller\EmailTemplateController@updateTemplate');
            Router::delete('/{pk}', 'Ports\Controller\EmailTemplateController@removeByPk');
        });

        Router::addGroup('/sms-template', function () {
            Router::addGroup('/service', function () {
                Router::get('/{serviceId}', 'Ports\Controller\SmsTemplateController@getAllByServiceId');
            });
            Router::get('/{pk}', 'Ports\Controller\SmsTemplateController@getByPk');
            Router::post('/', 'Ports\Controller\SmsTemplateController@create');
            Router::put('/', 'Ports\Controller\SmsTemplateController@updateTemplate');
            Router::delete('/{pk}', 'Ports\Controller\SmsTemplateController@removeByPk');
        });
    });

});


