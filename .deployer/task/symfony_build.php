<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 05/03/2025, 11:45
 *
 * @project IDMarinas Template Symfony
 * @see     https://github.com/idmarinas/template-symfony
 *
 * @file    symfony_build.php
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

//
// Task
//
desc('Build TailwindCSS for prod');
task('assets:build:tailwind', function () {
	writeln('<info>Generate Tailwind css file for {{local_prod_text}}</info>');
	runLocally('php bin/console tailwind:build --minify');
});

desc('Asset-Map compile');
task('assets:compile', function () {
	writeln('<info>Compile Asset-Map for {{local_prod_text}}</info>');
	runLocally('php bin/console asset-map:compile');
});

desc('Generate .env.local.php for prod');
task('deploy:generate:env', function () {
	writeln('<info>Generating .env.local.php for {{local_prod_text}}</info>');
	runlocally('php bin/console secrets:decrypt-to-local --force --env=prod');
	runLocally('composer dump-env prod');
	runLocally('php -f .docker/scripts/create_env_file.php');
});

desc('Build/Compile assets and Tailwind');
task('deploy:assets:build', [
	'assets:build:tailwind',
	'assets:compile',
]);

//
// Hooks
//
before('deploy:setup', 'deploy:assets:build');

after('deploy:assets:build', 'deploy:generate:env');
