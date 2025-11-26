<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 26/11/2025, 12:43
 *
 * @project IDMarinas Template Symfony
 * @see     https://github.com/idmarinas/template-symfony
 *
 * @file    deploy.php
 * @date    17/07/2025
 * @time    20:01
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.0.0
 */

namespace Deployer;

import(__DIR__ . '/.deployer/common.php');

//
// Config
//
set('user', 'IDMarinas');

//
// Hosts
//
host('sN.production')
	->setHostname('1.1.1.1')
	->setPort(22)
	->setRemoteUser('username')
	->setDeployPath('/var/www/html')
	->setLabels(['stage' => 'prod', 'role' => 'web', 'server_name' => 'Sn - Docker Server'])
;

task('docker:volume:restore')->disable();

//
// Deploy Task - Upload a new version
//
task('deploy', [
	'deploy:prepare',
	'download:backups',
	'deploy:upload_files',
	'docker:image:load',
	'docker:copy:env_docker',
	'deploy:symfony:workers:stop',
	'docker:service:start',
	'doctrine:migrations',
	'deploy:publish',
]);
