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
use Hyperf\Watcher\Driver\ScanFileDriver;
use Hyperf\Watcher\Driver\FindNewerDriver;
return [
    'driver' => FindNewerDriver::class,
    'bin' => PHP_BINARY,
    'watch' => [
        'dir' => ['src','config'],
        'file' => ['.env'],
        'scan_interval' => 2000,
    ],
    'ext' => ['.php', '.env'],
];
