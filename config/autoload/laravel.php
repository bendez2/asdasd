<?php


use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule;
$capsule->addConnection([
        'driver' => env('DB_DRIVER', 'pgsql'),
        'host' => env('DB_HOST', 'localhost'),
        'port' => env('DB_PORT', 5432),
        'database' => env('DB_DATABASE', 'your_database'),
        'username' => env('DB_USERNAME', 'your_username'),
        'password' => env('DB_PASSWORD', 'your_password'),
        'charset' => 'utf8',
        'collation' => 'utf8_unicode_ci',
        'prefix' => '',
       ]);
$capsule->setAsGlobal();
$capsule->bootEloquent();

return $capsule;
