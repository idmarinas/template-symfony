<?php

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Symfony\Component\DependencyInjection\ContainerBuilder;

return static function (ContainerConfigurator $container, ContainerBuilder $builder): void {
	if (!$builder->hasExtension('twig')) {
		return;
	}

	$container->extension('twig', [
		'paths' => [
			'apps/web/templates' => 'Web',
		],
	]);
};
