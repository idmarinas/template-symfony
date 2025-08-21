<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 21/08/2025, 18:33
 *
 * @project IDMarinas Template Symfony
 * @see     https://github.com/idmarinas/template-symfony
 *
 * @file    TestKernel.php
 * @date    21/08/2025
 * @time    14:02
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.0.0
 */

namespace Core\Tests;

use Core\AbstractKernel;
use Override;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

final class TestKernel extends AbstractKernel
{
	public function __construct (string $environment, bool $debug)
	{
		parent::__construct($environment, $debug, $_ENV['APP_ID']);
	}

	#[Override]
	protected function configureContainer (ContainerConfigurator $container): void
	{
		if ('core' == $this->id) {
			$this->doConfigureContainer($container, $this->getProjectDir() . '/config');

			return;
		}

		parent::configureContainer($container);
	}

	#[Override]
	public function registerBundles (): iterable
	{
		if ('core' == $this->id) {
			$coreBundles = require $this->getProjectDir() . '/config/bundles.php';

			foreach ($coreBundles as $class => $envs) {
				if ($envs[$this->environment] ?? $envs['all'] ?? false) {
					yield new $class();
				}
			}
		} else {
			yield from parent::registerBundles();
		}
	}

	#[Override]
	protected function configureRoutes (RoutingConfigurator $routes): void
	{
		if ('core' == $this->id) {
			$this->doConfigureRoutes($routes, $this->getProjectDir() . '/config');

			return;
		}

		parent::configureRoutes($routes);
	}
}
