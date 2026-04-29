<?php

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Symfony\Component\DependencyInjection\ContainerBuilder;

return static function (ContainerConfigurator $container, ContainerBuilder $builder): void {
	if (!$builder->hasExtension('twig_component')) {
		return;
	}

	$container->extension('twig_component', [
		'defaults' => [
			// Namespace & directory for components
			'Blog\\Twig\\Components\\' => 'app/blog/templates/components/',
		],
	]);
};
