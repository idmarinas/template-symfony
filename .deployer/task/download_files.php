<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 26/09/2025, 13:38
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

set('local/storage/backup', '.deployer/.storage/{{app/version}}');
set('docker/volumes', [
	'Public Uploads' => '{{docker/project_name}}_source_uploads',
	'Database Data'  => '{{docker/project_name}}_database_data',
]);

//
// Task
//
desc('Descargar los archivos logs del contenedor web.');
task('download:backups:logs', function () {
	writeln('<info>Descargando los "logs" del contenedor web a <fg=blue>{{local/storage/backup}}</>.</>');

	run('mkdir -p {{deploy_path}}/backups/log');

	if (test('{{bin/webserver}} sh -c "[ -d "/app/var/log" ]"')) {
		run('docker cp {{docker/project_name}}-webserver-1:/app/var/log {{deploy_path}}/backups/');
		download('{{deploy_path}}/backups/log/', '{{local/storage/backup}}/log/', ['options' => ['--mkpath']]);
		run('rm -r {{deploy_path}}/backups/log');
	} else {
		writeln('<fg=red>El contenedor web no tiene un directorio de logs.</>');
	}
});

desc('Descargar una copia de los volúmenes Docker.');
task('download:backups:volume', function () {
	writeln('<info>Creando una copia de los volúmenes Docker.</>');
	$volumes = get('docker/volumes');
	$backupVolumes = '{{deploy_path}}/backups/volumes';

	run("mkdir -p $backupVolumes");

	foreach ($volumes as $name => $volume) {
		writeln("<info>Creando copia del volumen '$name'.</>");
		$file = parse("{$volume}_backup.tar.gz");

		if (test('[ -n "$(docker volume ls -q --filter name=' . $volume . ')" ]')) {
			run("docker run --rm -v $volume:/volume debian:stable-slim tar -cz -C /volume . > $backupVolumes/$file");
		} else {
			writeln("<fg=red>El volumen $name: $volume no existe.</>");
		}
	}

	writeln('Descargando las copias de volúmenes a <fg=blue>{{local/storage/backup}}/volumes</>');
	// Se descargan los volúmenes
	download('{{deploy_path}}/backups/volumes/', '{{local/storage/backup}}/volumes/', ['options' => ['--mkpath']]);
	// Borrar el directorio "volumes" una vez descargados los archivos
	run('rm -r {{deploy_path}}/backups/volumes');
});

task('download:backups', ['download:backups:logs', 'download:backups:volume']);
