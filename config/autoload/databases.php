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
use function Hyperf\Support\env;


return [
    'default' => [
        'driver'    => env('DB_CONNECTION', 'pgsql'),
        'host'      => env('DB_HOST', 'localhost'),
        'port'      => env('DB_PORT', 5432),
        'database'  => env('DB_DATABASE', 'database'),
        'username'  => env('DB_USERNAME', 'username'),
        'password'  => env('DB_PASSWORD', 'password'),
        'charset'   => 'utf8',
        'collation' => 'utf8_unicode_ci',
        'prefix'    => '',
    ],
];