<?php

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
