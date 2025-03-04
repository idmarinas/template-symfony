<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 04/03/2025, 23:37
 *
 * @project IDMarinas Template Symfony
 * @see     https://github.com/idmarinas/template-symfony
 *
 * @file    clearcache.php
 * @date    04/03/2025
 * @time    23:47
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.0.0
 */

/** @noinspection PhpUnhandledExceptionInspection */

namespace Deployer;

//
// Tasks
//

desc('Clear cache OPcache, APCu, file status and realpath');
task('deploy:cache:clear:system', [
	'cachetool:clear:opcache',
	//'cachetool:clear:apcu',
	'cachetool:clear:stat',
]);

//
// Hooks
//
before('deploy:publish', 'deploy:clear_paths');
