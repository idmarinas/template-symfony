<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 21/08/2025, 18:06
 *
 * @project IDMarinas Template Symfony
 * @see     https://github.com/idmarinas/template-symfony
 *
 * @file    AppIdExtension.php
 * @date    21/08/2025
 * @time    15:43
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.0.0
 */

namespace Core\Tests\PHPUnit\Extension;

use Override;
use PHPUnit\Runner\Extension\Extension;
use PHPUnit\Runner\Extension\Facade;
use PHPUnit\Runner\Extension\ParameterCollection;
use PHPUnit\TextUI\Configuration\Configuration;

class AppIdExtension implements Extension
{
	#[Override]
	public function bootstrap (Configuration $configuration, Facade $facade, ParameterCollection $parameters): void
	{
		$facade->registerSubscriber(new AppIdSubscriber());

		$clearCache = $parameters->get('clear-cache');
		$clear = match (true) {
			$clearCache == 'off',
				$clearCache == 'no',
				$clearCache == 'false' => false,
			default                  => (bool)$clearCache,
		};

		if ($parameters->has('clear-cache') && $clear) {
			$facade->registerSubscriber(new ClearCacheSubscriber());
		}
	}
}
