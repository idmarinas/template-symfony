<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 14/09/2025, 12:12
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

require __DIR__ . '/vendor/autoload.php';

use Symfony\Component\Dotenv\Dotenv;

// Obtener las variables .env en $_ENV
new Dotenv()->bootEnv(__DIR__ . '/.env');

import(__DIR__ . '/.deployer/common_text_vars.php');
import(__DIR__ . '/.deployer/task/docker.php');
import(__DIR__ . '/.deployer/task/upload_files.php');
import(__DIR__ . '/.deployer/task/doctrine.php');
import(__DIR__ . '/.deployer/task/maintenance.php');
import(__DIR__ . '/.deployer/task/symfony_workers.php');
import(__DIR__ . '/.deployer/task/download_files.php');

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
set('app_version', $_ENV['APP_VERSION'] ?? '0.0.0');
set('cleanup_use_sudo', true);
set('docker_services_to_start', 'webserver database '); // messenger_worker_scheduler messenger_worker_async
set('msn_workers_container_names', [
//    'Worker Async' => 'template_symfony-messenger_worker_async-1',
//    'Worker Scheduler' => 'template_symfony-messenger_worker_scheduler-1',
]);

// Path to the bin *.
set('bin/webserver', 'docker exec template_symfony-webserver-1');
set('bin/php', '{{bin/webserver}} php');
set('bin/composer', '{{bin/webserver}} composer');
set('bin/console', '{{bin/php}} bin/console');

set('http_user', 'www-data');
set('http_group', 'www-data');

//
// Hosts
//
host('sN.production')
    ->setHostname('1.1.1.1')
    ->setPort(22)
    ->setRemoteUser('username')
    ->setDeployPath('/var/www/html')
    ->setLabels(['stage' => 'prod', 'role' => 'web', 'server_name' => 'Docker Server'])
;

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
    'docker:container:start',
    'doctrine:migrations',
    //    'deploy:env',
    //    'deploy:shared',
    //    'deploy:writable',
    'deploy:publish',
]);

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
