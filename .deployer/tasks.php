<?php

namespace Deployer;

import('recipe/common.php');

import(__DIR__ . '/task/docker.php');
import(__DIR__ . '/task/upload_files.php');
import(__DIR__ . '/task/doctrine.php');
import(__DIR__ . '/task/maintenance.php');
import(__DIR__ . '/task/symfony_workers.php');
import(__DIR__ . '/task/download_files.php');
import(__DIR__ . '/task/restore_volumes.php');

task('deploy:prepare', [
	'deploy:info',
	'deploy:setup',
	'deploy:lock',
	'deploy:release',
	'docker:image:build',
]);
task('deploy:publish', [
	'deploy:symlink',
	'deploy:unlock',
	'maintenance:off',
	'deploy:cleanup',
	'deploy:success',
]);
