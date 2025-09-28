<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 28/09/2025, 18:22
 *
 * @project IDMarinas Template Symfony
 * @see     https://github.com/idmarinas/template-symfony
 *
 * @file    upload_files.php
 * @date    05/03/2025
 * @time    11:48
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.0.0
 */

namespace Deployer;

import('recipe/common.php');

desc('Upload files to server');
task('deploy:upload_files', function () {
	writeln('<fg=blue>Subiendo archivos a {{text_prod}}...</>');
	upload('./', '{{release_path}}', [
		'flags'   => '-azPh',
		'options' => [
			'--include=compose.yaml',
			'--include=compose.prod.yaml',
			'--exclude=**/*',
			'--chmod=F440',
		],
	]);
	writeln('<fg=blue>Subiendo {{docker/image/tar}} a {{text_prod}}...</>');
	upload('./.deployer/{{docker/image/tar}}', '{{release_path}}', [
		'options' => ['--chmod=F750'],
	]);
});

desc('Borrar el archivo de la imagen .tar una vez completado el deploy.');
task('deploy:clean:image_tar', function () {
	writeln('<fg=red>Borrando {{docker/image/tar}} de {{text_prod}}...</>');

	run('rm {{release_path}}/{{docker/image/tar}}');
});

after('deploy:success', 'deploy:clean:image_tar');
