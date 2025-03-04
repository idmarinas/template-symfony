<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 04/03/2025, 23:51
 *
 * @project IDMarinas Template Symfony
 * @see     https://github.com/idmarinas/template-symfony
 *
 * @file    local_dev_clear_paths.php
 * @date    04/03/2025
 * @time    23:47
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.0.0
 */

/** @noinspection PhpUnhandledExceptionInspection */

namespace Deployer;

import('recipe/common.php');

set('local_clear_paths', ['.env.local.php']);
set('local_clear_use_sudo', false);

desc('Cleaning local files and/or directories (PROD files/dirs)');
task('local:dev:clear_paths', function () {
	$paths = get('local_clear_paths');
	$sudo = get('local_clear_use_sudo') ? 'sudo' : '';
	$batch = 100;

	$commands = [];
	foreach ($paths as $path) {
		$commands[] = "$sudo rm -rf $path";
	}

	$chunks = array_chunk($commands, $batch);
	foreach ($chunks as $chunk) {
		testLocally(implode('; ', $chunk));
	}
});

//
// Hooks
//
after('deploy:publish', 'local:dev:clear_paths');
