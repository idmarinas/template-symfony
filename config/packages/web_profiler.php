<?php

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Symfony\Component\DependencyInjection\ContainerBuilder;

return static function (ContainerConfigurator $container, ContainerBuilder $builder): void {
	if (!$builder->hasExtension('web_profiler')) {
		return;
	}

	if ('dev' === $container->env()) {
		$container->extension('web_profiler', [
			'toolbar' => true,
		]);

		$container->extension('framework', [
			'profiler' => [
				'collect_serializer_data' => true,
			],
		]);
	}

	if ('test' === $container->env()) {
		$container->extension('web_profiler', [
			'toolbar' => false,
		]);
		$container->extension('framework', [
			'profiler' => [
				'collect'                 => false,
				'collect_serializer_data' => true,
			],
		]);
	}
};
