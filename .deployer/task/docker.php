<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 14/09/2025, 11:32
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

/** @noinspection ALL */

namespace Deployer;

import('recipe/common.php');

set('env_compose_files', '--env-file .env.docker -f compose.yaml -f compose.prod.yaml');
set('docker_services_to_start', 'webserver database');

//
// Tasks
//
desc('Construir la imagen Docker (PROD)');
task('docker:image:build', function () {
    if (!testLocally('[ -f .deployer/idmarinas_pfc_{{app_version}}.tar ]')) {
        writeln('<info>Construyendo imagen Docker</>');
        runLocally(
            'docker build --target prod -f .docker/Dockerfile -t idmarinas/pfc:{{app_version}} .',
            timeout: null
        );

        writeln('<info>Creando archivo .tar de la imagen Docker</>');
        runLocally(
            'docker save -o .deployer/idmarinas_pfc_{{app_version}}.tar idmarinas/pfc:{{app_version}}',
            timeout: null
        );
    } else {
        writeln('<info>Imagen Docker ya construida</>');
    }
});

desc('Docker Image for Prod');
task('docker:image:load', function () {
    writeln('<info>Cargando imagen en "{{text_prod}}"</>');
    run('docker load -i {{release_path}}/idmarinas_pfc_{{app_version}}.tar');
});

desc('Copiar archivo .env.docker de la imagen Docker');
task('docker:copy:env_docker', function () {
    writeln('<info>Copiando archivo .env.docker</>');
    run('docker create --name idmarinas_pfc_temp idmarinas/pfc:{{app_version}}');
    run('docker cp idmarinas_pfc_temp:/app/.env.docker {{release_path}}/.env.docker');
    run('docker rm idmarinas_pfc_temp');
});

desc('Iniciar de los contenedores Docker');
task('docker:container:start', function () {
    writeln('<info>Creando contenedor Docker en "{{text_prod}}"</>');
    within('{{release_or_current_path}}', function () {
        run('docker compose {{env_compose_files}} up --force-recreate -d --wait {{docker_services_to_start}}');
    });
});

desc('Eliminar imágenes Docker no utilizadas');
task('docker:image:prune', function () {
    run('docker image prune -f', real_time_output: true);
});

before('deploy:cleanup', 'docker:image:prune');
