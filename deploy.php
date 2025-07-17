<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 17/07/2025, 20:01
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

/** @noinspection PhpUnhandledExceptionInspection */

/*
 * TODO: updating the database
 * TODO: Revisar, porque se usa Docker para PHP, DB, y APACHE, muchos comandos no funcionaran porque se usa la
 *       consola del host
 */

namespace Deployer;

import('contrib/cachetool.php');
import(__DIR__ . '/.deployer/var_texts_common.php');
import(__DIR__ . '/.deployer/task/clearcache.php');
import(__DIR__ . '/.deployer/task/symfony_build.php');
import(__DIR__ . '/.deployer/task/upload_files.php');
//import(__DIR__ . '/.deployer/permissions_task.php');
import(__DIR__ . '/.deployer/task/symfony_workers.php');
//import(__DIR__ . '/.deployer/download_files_task.php');
import(__DIR__ . '/.deployer/task/local_dev_clear_paths.php');
import(__DIR__ . '/.deployer/task/local_dev_restore.php');
import('recipe/symfony.php');

//
// Config
//
set('project_name', 'IDMarinas Template Symfony');
set('user', 'idmarinas');
// Release number
set('release_name', fn() => within('{{deploy_path}}', function () {
	$latest = run('cat .dep/latest_release || echo 0');

	return str_pad(strval(intval($latest) + 1), 10, '0', STR_PAD_LEFT);
}));
set('keep_releases', 5);
set('what', get('project_name'));
set('composer_options', '--no-progress --no-dev --no-scripts --classmap-authoritative');

set('http_user', 'www-data');
set('http_group', 'www-data');

add('local_clear_paths', ['public/assets/', '.env.prod.local']);
add('clear_paths', ['cachetool.phar', 'migrations/']);

//
// Hosts
//
host('production')
	->setHostname('1.1.1.1')
	->setPort(22)
	->setRemoteUser('username')
	->setDeployPath('/var/www/html')
;

//
// Hooks
//
before('deploy:vendors', 'deploy:cache:clear:system');
after('deploy:failed', 'deploy:unlock');

//
// Disable unnecessary tasks
//
task('deploy:env')->disable();
task('deploy:shared')->disable();
task('deploy:writable')->disable();
