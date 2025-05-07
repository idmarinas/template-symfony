<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 05/03/2025, 11:46
 *
 * @project IDMarinas Template Symfony
 * @see     https://github.com/idmarinas/template-symfony
 *
 * @file    download_files_task.php
 * @date    07/05/2025
 * @time    22:07
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.0.0
 */

/** @noinspection PhpUnhandledExceptionInspection */

namespace Deployer;

import('recipe/common.php');

//
// Task
//
desc('Download log files and delete from {{local_prod_text}}');
task('deploy:download:log_files', function () {
	writeln('<info>Downloading log files to <fg=blue;>local storage</></info>');
	$version = strrchr(parse('{{previous_release}}'), '/');
	download('{{deploy_path}}/shared/var/log/*.log', "storage/prod/logs$version/");

	writeln('<info>Deleting log files from {{local_prod_text}} log/</info>');
	run('rm {{deploy_path}}/shared/var/log/*.log');
});

//
// Hooks
//
after('deploy:vendors', 'deploy:download:log_files');
