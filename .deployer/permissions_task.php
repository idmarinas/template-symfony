<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 05/03/2025, 11:55
 *
 * @project IDMarinas Template Symfony
 * @see     https://github.com/idmarinas/template-symfony
 *
 * @file    permissions_task.php
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

desc('Fix permissions of dirs and files');
task('deploy:fix:permissions', function () {
	writeln('<info>Fix permissions of dirs and files in {{local_prod_text}} server</info>');
	within('{{release_path}}', function () {
		run('chmod 440 .env.local.php');
		//		run('find var -type d -exec chmod 775 {} \;');
		run('setfacl -dR -m g:www-data:rwX u:www-data:rwX u:ftpuser:rwX var/');
		run('setfacl -R -m g:www-data:rwX u:www-data:rwX u:ftpuser:rwX var/');
	});
});

//
// Hooks
//
after('deploy:writable', 'deploy:fix:permissions');
