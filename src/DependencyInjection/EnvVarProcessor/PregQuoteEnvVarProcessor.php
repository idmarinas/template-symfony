<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 09/07/2025, 17:50
 *
 * @project IDMarinas Template Symfony
 * @see     https://github.com/idmarinas/template-symfony
 *
 * @file    PregQuoteEnvVarProcessor.php
 * @date    09/07/2025
 * @time    17:48
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.0.0
 */

namespace Core\DependencyInjection\EnvVarProcessor;

use Closure;
use Symfony\Component\DependencyInjection\EnvVarProcessorInterface;

class PregQuoteEnvVarProcessor implements EnvVarProcessorInterface
{
	/**
	 * @inheritDoc
	 */
	public function getEnv (string $prefix, string $name, Closure $getEnv): mixed
	{
		$env = $getEnv($name);

		return preg_quote($env);
	}

	/**
	 * @inheritDoc
	 */
	public static function getProvidedTypes (): array
	{
		return ['preg_quote' => 'string'];
	}
}
