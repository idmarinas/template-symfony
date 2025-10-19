<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 19/10/2025, 18:48
 *
 * @project IDMarinas Template Symfony
 * @see     https://github.com/idmarinas/template-symfony
 *
 * @file    doctrine_migrations.php
 * @date    05/05/2025
 * @time    21:02
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.0.0
 */

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Symfony\Component\DependencyInjection\ContainerBuilder;

return static function (ContainerConfigurator $container, ContainerBuilder $builder): void {
	if (!$builder->hasExtension('doctrine_migrations')) {
		return;
	}

	$container->extension('doctrine_migrations', [
		'migrations_paths'    => [
			# namespace is arbitrary but should be different from App\Migrations
			# as migration classes should NOT be autoloaded
			'DoctrineMigrations' => '%kernel.project_dir%/migrations',
		],
		'enable_profiler'     => false,
		# Possible values => "BY_YEAR", "BY_YEAR_AND_MONTH", false
		'organize_migrations' => 'BY_YEAR_AND_MONTH',
	]);
};
