<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 25/09/2025, 12:11
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
	writeln('<info>Descargando una copia de los volúmenes Docker.</>');
	$volumes = get('docker/volumes');

	foreach ($volumes as $name => $volume) {
		writeln("<info>Descargando una copia del volumen '$name' a <fg=blue>{{local/storage/backup}}</>.</>");
		$file = parse('{{$volume}}_backup.tar.gz');

		if (test('[ -n "$(docker volume ls -q --filter name=' . $volume . ')" ]')) {
			run("docker run --rm -v $volume:/volume debian:stable-slim tar -cz -C /volume . > {{deploy_path}}/backups/$file");
			run('mkdir -p {{deploy_path}}/backups');
			download("{{deploy_path}}/backups/$file", '{{local/storage/backup}}');
			run("rm -r {{deploy_path}}/backups/$file");
		} else {
			writeln("<fg=red>El volumen $name: $volume no existe.</>");
		}
	}
});

task('download:backups', ['download:backups:logs', 'download:backups:uploads']);
