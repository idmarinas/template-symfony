<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 05/03/2025, 11:46
 *
 * @project IDMarinas Template Symfony
 * @see     https://github.com/idmarinas/template-symfony
 *
 * @file    local_dev_clear_paths.php
 * @date    05/03/2025
 * @time    11:48
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.0.0
 */

/** @noinspection PhpUnhandledExceptionInspection */

namespace Deployer;

import('recipe/common.php');

// List of paths to remove from local
set('local_clear_paths', ['.env.local.php']);

// Use sudo for local:dev:clear_paths task?
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
