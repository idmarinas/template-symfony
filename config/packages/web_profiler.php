<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 18/03/2025, 15:47
 *
 * @project IDMarinas Template Symfony
 * @see     https://github.com/idmarinas/template-symfony
 *
 * @file    web_profiler.php
 * @date    18/03/2025
 * @time    13:57
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.0.0
 */

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Symfony\Component\DependencyInjection\ContainerBuilder;

return static function (ContainerConfigurator $container, ContainerBuilder $builder): void {
	if (!$builder->hasExtension('web_profiler')) {
		return;
	}

	if ('dev' === $container->env()) {
		$container->extension('web_profiler', [
			'toolbar'             => true,
			'intercept_redirects' => false,
		]);

		$container->extension('framework', [
			'profiler' => [
				'only_exceptions'         => false,
				'collect_serializer_data' => true,
			],
		]);
	}

	if ('test' === $container->env()) {
		$container->extension('web_profiler', [
			'toolbar'             => false,
			'intercept_redirects' => false,
		]);
		$container->extension('framework', [
			'profiler' => [
				'collect' => false,
			],
		]);
	}
};
