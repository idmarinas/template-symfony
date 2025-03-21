<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 18/03/2025, 16:22
 *
 * @project IDMarinas Template Symfony
 * @see     https://github.com/idmarinas/template-symfony
 *
 * @file    Kernel.php
 * @date    18/02/2025
 * @time    22:49
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.0.0
 */

namespace Shared;

use Override;
use ReflectionObject;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

class Kernel extends BaseKernel
{
	use MicroKernelTrait;

	public function __construct (string $environment, bool $debug, private readonly string $id)
	{
		parent::__construct($environment, $debug);
	}

	#[Override]
	public function getProjectDir (): string
	{
		return dirname(__DIR__);
	}

	public function getSharedConfigDir (): string
	{
		return $this->getProjectDir() . '/config';
	}

	public function getAppConfigDir (): string
	{
		return $this->getProjectDir() . '/apps/' . $this->id . '/config';
	}

	public function registerBundles (): iterable
	{
		$sharedBundles = require $this->getSharedConfigDir() . '/bundles.php';
		$appBundles = require $this->getAppConfigDir() . '/bundles.php';

		// load common bundles, such as the FrameworkBundle, as well as
		// specific bundles required exclusively for the app itself
		foreach (array_merge($sharedBundles, $appBundles) as $class => $envs) {
			if ($envs[$this->environment] ?? $envs['all'] ?? false) {
				yield new $class();
			}
		}
	}

	public function getCacheDir (): string
	{
		// divide cache for each application
		$dir = ($_SERVER['APP_CACHE_DIR'] ?? $this->getProjectDir() . '/var/cache');

		return $dir . '/' . $this->id . '/' . $this->environment;
	}

	public function getLogDir (): string
	{
		// divide logs for each application
		return ($_SERVER['APP_LOG_DIR'] ?? $this->getProjectDir() . '/var/log') . '/' . $this->id;
	}

	protected function configureContainer (ContainerConfigurator $container): void
	{
		// load common config files, such as the framework.yaml, as well as
		// specific configs required exclusively for the app itself
		$this->doConfigureContainer($container, $this->getSharedConfigDir());
		$this->doConfigureContainer($container, $this->getAppConfigDir());
	}

	protected function configureRoutes (RoutingConfigurator $routes): void
	{
		// load common routes files, such as the routes/framework.yaml, as well as
		// specific routes required exclusively for the app itself
		$this->doConfigureRoutes($routes, $this->getSharedConfigDir());
		$this->doConfigureRoutes($routes, $this->getAppConfigDir());
	}

	private function doConfigureContainer (ContainerConfigurator $container, string $configDir): void
	{
		$container->import($configDir . '/{packages}/*.{php,yaml}');

		if (is_file($configDir . '/services.yaml')) {
			$container->import($configDir . '/services.yaml');
		} else {
			$container->import($configDir . '/{services}.php');
		}
	}

	private function doConfigureRoutes (RoutingConfigurator $routes, string $configDir): void
	{
		$exclude = match ($this->id) {
			'api'   => $configDir . '/{routes}/{web_profiler}.{php,yaml}',
			default => null,
		};

		$routes->import($configDir . '/{routes}/*.{php,yaml}', exclude: $exclude);

		if (is_file($configDir . '/routes.yaml')) {
			$routes->import($configDir . '/routes.yaml');
		} else {
			$routes->import($configDir . '/{routes}.php');
		}

		if (false !== ($fileName = new ReflectionObject($this)->getFileName())) {
			$routes->import($fileName, 'attribute');
		}
	}
}
