<?php

declare(strict_types=1);
/**
 * This file is part of the Ray.Aop package.
 *
 * @license http://opensource.org/licenses/MIT MIT
 */
require dirname(__DIR__) . '/vendor/autoload.php';
$_ENV['TMP_DIR'] = __DIR__ . '/tmp';
array_map('unlink', glob("{$_ENV['TMP_DIR']}/*.php"));
