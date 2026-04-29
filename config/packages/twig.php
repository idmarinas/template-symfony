<?php

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Symfony\Component\DependencyInjection\ContainerBuilder;

return static function (ContainerConfigurator $container, ContainerBuilder $builder): void {
	if (!$builder->hasExtension('twig')) {
		return;
	}

	$container->extension('twig', [
		'file_name_pattern' => '*.twig',
		'paths'             => [],
		'form_themes'       => [],
		'globals'           => [
			'app_version' => env('APP_VERSION'),
			'app_title'   => env('APP_TITLE'),
		],
	]);

	if ('test' === $container->env()) {
		$container->extension('twig', [
			'strict_variables' => true,
		]);
	}
};
