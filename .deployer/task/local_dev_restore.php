<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 04/03/2025, 23:51
 *
 * @project IDMarinas Template Symfony
 * @see     https://github.com/idmarinas/template-symfony
 *
 * @file    local_dev_restore.php
 * @date    04/03/2025
 * @time    23:52
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.0.0
 */

/** @noinspection PhpUnhandledExceptionInspection */

namespace Deployer;

import('recipe/common.php');

//
// Task
//
desc('Recreate files for DEV');
task('local:dev:restore', function () {
	writeln('<info>Creating files for {{local_dev_text}}</info>');
	runLocally('rm -rf public/assets/');
	runLocally('composer dev:dump:env');
	runLocally('php -f .docker/scripts/create_env_file.php');

	writeln('<info>Creating Tailwind CSS for {{local_dev_text}}</info>');
	runLocally('php bin/console tailwind:build');
});

//
// Hooks
//
after('local:dev:clear_paths', 'local:dev:restore');
