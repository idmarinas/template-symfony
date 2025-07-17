<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 07/07/2025, 14:15
 *
 * @project IDMarinas Template Symfony
 * @see     https://github.com/idmarinas/template-symfony
 *
 * @file    bootstrap.php
 * @date    19/02/2025
 * @time    19:50
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.0.0
 */

use Core\Kernel;
use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\Filesystem\Filesystem;

require dirname(__DIR__) . '/vendor/autoload.php';

if (method_exists(Dotenv::class, 'bootEnv')) {
	new Dotenv()->bootEnv(dirname(__DIR__) . '/.env');
}

if ($_SERVER['APP_DEBUG']) {
	umask(0000);
}

$kernel = new Kernel('test', true);
$fs = new Filesystem();

if ($fs->exists($kernel->getCacheDir())) {
	$fs->remove($kernel->getCacheDir());
}

if ($fs->exists($kernel->getLogDir())) {
	$fs->remove($kernel->getLogDir());
}
