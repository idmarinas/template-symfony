<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 24/09/2025, 12:22
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
	writeln('<fg=blue>Subiendo idmarinas_pfc_{{app/version}}.tar a {{text_prod}}...</>');
	upload('./.deployer/idmarinas_pfc_{{app/version}}.tar', '{{release_path}}', [
		'options' => ['--chmod=F750'],
	]);
});
