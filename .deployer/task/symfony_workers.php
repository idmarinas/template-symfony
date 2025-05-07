<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 05/03/2025, 12:02
 *
 * @project IDMarinas Template Symfony
 * @see     https://github.com/idmarinas/template-symfony
 *
 * @file    symfony_workers.php
 * @date    07/05/2025
 * @time    22:07
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
// Tasks
//
desc('Stop works of previous release');
task('remote:prod:workers:stop', function () {
	writeln('<info>Stop workers of <fg=red;options=bold>previous</> release in {{local_prod_text}}</info>');
	within('{{previous_release}}', function () {
		run('php bin/console cron:stop', real_time_output: true);
		run('php bin/console messenger:stop-workers', real_time_output: true);
	});
});

desc('Start works of current release');
task('remote:prod:workers:start', function () {
	writeln('<info>Start workers of <fg=green;options=bold>current</> release in {{local_prod_text}}</info>');
	within('{{release_path}}', function () {
		run('php bin/console cron:start > /dev/null 2>&1 &');
	});
});

desc('Workers manager');
task('remote:prod:workers', [
	'remote:prod:workers:stop',
	'remote:prod:workers:start',
]);

//- exec: { cmd: 'php bin/console cron:stop', desc: 'Stop Cron scheduler'}
//- exec: { cmd: 'php bin/console messenger:stop-workers', desc: 'Se paran todos los workers del messenger' }

//
// Hooks
//
before('deploy:publish', 'remote:prod:workers');
