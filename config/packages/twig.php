<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 19/10/2025, 18:48
 *
 * @project IDMarinas Template Symfony
 * @see     https://github.com/idmarinas/template-symfony
 *
 * @file    twig.php
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
	// @formatter:off
	if (!$builder->hasExtension('twig')) {
		return;
	}

	$container->extension('twig', [
		'file_name_pattern' => '*.twig',
		'paths' => [
			'apps/admin/templates' => 'Admin',
			'apps/blog/templates' => 'Blog',
			'apps/forum/templates' => 'Forum',
			'apps/web/templates' => 'Web',
//			'vendor/idmarinas/ui-bundle/templates/bundles/TwigBundle' => 'Twig' // Custom error pages
		],
		'form_themes' => [],
		'globals' => [
			'app_version' => env('APP_VERSION'),
		],
	]);

	if ('test' === $container->env()) {
		$container->extension('twig', [
			'strict_variables' => true,
		]);
	}
};
