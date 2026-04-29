<?php

namespace Deployer;

use Exception;

import('recipe/common.php');

//
// Project Config
//
set('app/version', $_ENV['APP_VERSION'] ?? '0.0.0');
set('app/version/build', $_ENV['APP_VERSION_BUILD'] ?? 1);
set('docker/project_name', $_ENV['APP_PROJECT_NAME'] ?? 'your_project_name');
set('github/user', $_ENV['GITHUB_USER'] ?? get('user'));
set('github/repository', $_ENV['GITHUB_REPOSITORY'] ?? '');
set('github/repository/name', $_ENV['GITHUB_REPOSITORY_NAME'] ?? 'your-project-name');
set('project_name', $_ENV['APP_TITLE'] ?? 'Your Project Name');
set('what', get('project_name'));

//
// Config
//

set('cleanup_use_sudo', true);
set('keep_releases', 5);
// Release number
set('release_name', fn() => within('{{deploy_path}}', function () {
	$latest = run('cat .dep/latest_release || echo 0');

	return str_pad(strval(intval($latest) + 1), 10, '0', STR_PAD_LEFT);
}));

set('http_user', 'www-data');
set('http_group', 'www-data');

// Path to the bin *.
set('bin/webserver', 'docker exec {{docker/project_name}}-webserver-1');
set('bin/php', '{{bin/webserver}} php');
set('bin/composer', '{{bin/webserver}} composer');
set('bin/console', '{{bin/php}} bin/console');

//
// Variables de texto personalizadas
//

set('text_prod', function () {
	$name = currentHost()->getLabels()['server_name'] ?? 'unknown';

	return "<fg=green>$name</> en <fg=magenta;options=bold>PROD</>";
});
set('text_dev', '<fg=yellow>localhost</> en <fg=red;options=bold>DEV</>');

//
// Funciones reutilizables
//

/**
 * @throws Exception
 */
function parseServicesToContainers(array $services): array
{
	if ([] === $services) {
		throw error('No hay servicios para iniciar.');
	}

	return array_map(fn($service) => parse("{{docker/project_name}}-$service-1"), $services);
}

/**
 * @throws Exception
 */
function getVolumeDirs(string $container): string
{
	$volumes = run("docker inspect $container");
	$volumes = array_filter(json_decode($volumes, true)[0]['Mounts'], fn($mount) => 'volume' === $mount['Type']);

	if ([] === $volumes) {
		throw error("No se han encontrado volúmenes para <fg=yellow;options=bold>$container</>");
	}

	return implode(' ', array_map(fn($v) => $v['Destination'], $volumes));
}

//
// Tasks
//
import(__DIR__.'/task/docker.php');
import(__DIR__.'/task/upload_files.php');
import(__DIR__.'/task/doctrine.php');
import(__DIR__.'/task/maintenance.php');
import(__DIR__.'/task/symfony_workers.php');
import(__DIR__.'/task/download_files.php');
import(__DIR__.'/task/restore_volumes.php');
