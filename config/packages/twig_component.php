<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 18/03/2025, 14:30
 *
 * @project IDMarinas Template Symfony
 * @see     https://github.com/idmarinas/template-symfony
 *
 * @file    twig_component.php
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
	if (!$builder->hasExtension('twig_component')) {
		return;
	}

	$container->extension('twig_component', [
		'anonymous_template_directory' => 'components/',
		'defaults' => [
			// Namespace & directory for components
			'Shared\\Twig\\Component\\' => 'components/',
			'Admin\\Twig\\Component\\' => 'app/admin/templates/components/',
			'Web\\Twig\\Component\\' => 'app/admin/templates/components/',
		],
	]);
};
