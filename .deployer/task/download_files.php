<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 14/09/2025, 11:32
 *
 * @project IDMarinas Template Symfony
 * @see     https://github.com/idmarinas/template-symfony
 *
 * @file    download_files.php
 * @date    07/05/2025
 * @time    22:07
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.0.0
 */

namespace Deployer;

import('recipe/common.php');

set('storage_backup', '.deployer/.storage/{{app_version}}');

/*
 * descargar volúmenes Docker como copia de seguridad
 * También los logs del contenedor, que no están en un volumen
 */

//
// Task
//
desc('Descargar los archivos logs del contenedor web.');
task('download:backups:logs', function () {
    writeln('<info>Descargando los archivos logs del contenedor web a <fg=blue>{{storage_backup}}</>.</>');

    run('mkdir -p {{deploy_path}}/backups');
    run('docker cp pfc-webserver-1:/app/var/log {{deploy_path}}/backups');
    download('{{deploy_path}}/backups/log', '{{storage_backup}}');
    run('rm -r {{deploy_path}}/backups/log');
});

desc('Descargar una copia de subidas "uploads".');
task('download:backups:uploads', function () {
    writeln('<info>Descargando una copia de los archivos en subidas "uploads" a <fg=blue>{{storage_backup}}</>.</>');

    run(
        'docker run --rm -v pfc_source_uploads:/volume debian:stable-slim \
                    tar -cz -C /volume . > {{deploy_path}}/backups/pfc_source_uploads_backup.tar.gz'
    );
    run('mkdir -p {{deploy_path}}/backups');
    download('{{deploy_path}}/backups/pfc_source_uploads_backup.tar.gz', '{{storage_backup}}');
    run('rm -r {{deploy_path}}/backups/pfc_source_uploads_backup.tar.gz');
});

task('download:backups', ['download:backups:logs', 'download:backups:uploads']);
