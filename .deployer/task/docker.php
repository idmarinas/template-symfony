<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 24/09/2025, 13:38
 *
 * @project IDMarinas Template Symfony
 * @see     https://github.com/idmarinas/template-symfony
 *
 * @file    docker.php
 * @date    10/09/2025
 * @time    18:02
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.0.0
 */

namespace Deployer;

import('recipe/common.php');

set('docker/compose/files', '--env-file .env.docker -f compose.yaml -f compose.prod.yaml');
set('docker/services/start', 'webserver database');
set('docker/project_name', 'template_symfony');
set('docker/image/name', 'idmarinas/{{docker/project_name}}:{{app/version}}');
set('docker/image/tar', 'deployer_{{docker/project_name}}_{{app/version}}.tar');

//
// Tasks
//
desc('Construir la imagen Docker (PROD)');
task('docker:image:build', function () {
	if (!testLocally('[ -f .deployer/{{docker/image/tar}} ]')) {
		writeln('<info>Construyendo imagen Docker</>');
		runLocally('docker build --target prod -f .docker/Dockerfile -t {{docker/image/name}} .', timeout: null);

		writeln('<info>Creando archivo .tar de la imagen Docker</>');
		runLocally('docker save -o .deployer/{{docker/image/tar}} {{docker/image/name}}', timeout: null);
	} else {
		writeln('<info>Imagen Docker y archivo .tar ya construidos</>');
	}
});

desc('Docker Image for Prod');
task('docker:image:load', function () {
	writeln('<info>Cargando imagen en "{{text_prod}}"</>');
	run('docker load -i {{release_path}}/{{docker/image/tar}}');
});

desc('Copiar archivo .env.docker de la imagen Docker');
task('docker:copy:env_docker', function () {
	writeln('<info>Copiando archivo .env.docker</>');
	run('docker create --name deployer_{{docker/project_name}}_temp {{docker/image/name}}');
	run('docker cp deployer_{{docker/project_name}}_temp:/app/.env.docker {{release_path}}/.env.docker');
	run('docker rm deployer_{{docker/project_name}}_temp');
});

desc('Iniciar de los contenedores Docker');
task('docker:container:start', function () {
	writeln('<info>Creando contenedor Docker en "{{text_prod}}"</>');
	within('{{release_or_current_path}}', function () {
		run('docker compose {{docker/compose/files}} up --force-recreate -d --wait {{docker_services_to_start}}');
	});
});

desc('Eliminar imágenes Docker no utilizadas');
task('docker:image:prune', function () {
	run('docker image prune -f', real_time_output: true);
});

before('deploy:cleanup', 'docker:image:prune');
