<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 05/03/2025, 11:46
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

/** @noinspection PhpUnhandledExceptionInspection */

namespace Deployer;

import('recipe/common.php');

desc('Upload files to server');
task('deploy:upload_files', function () {
	writeln('<info>Uploading files to {{local_prod_text}} server...</info>');
	upload('./', '{{release_path}}', [
		'flags'   => '-azPh',
		'options' => [
			'--include=.env.local.php',
			'--exclude-from=.deployer/exclude_files',
			'--bwlimit=4096',
			'--chmod=D770,F664',
		],
	]);
});
// Disable deploy:update_code and add deploy:upload_files
task('deploy:update_code')
	->disable()
	->addBefore('deploy:upload_files')
;
