<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 21/08/2025, 19:07
 *
 * @project IDMarinas Template Symfony
 * @see     https://github.com/idmarinas/template-symfony
 *
 * @file    CreateClientTrait.php
 * @date    21/08/2025
 * @time    18:53
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.0.0
 */

namespace Core\Tests;

use Override;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * @mixin WebTestCase
 */
trait CreateClientTrait
{
	public static function appId (): string
	{
		return match ($_ENV['APP_ID']) {
			'web',
			'core'  => 'www',
			default => $_ENV['APP_ID'],
		};
	}

	#[Override]
	protected static function createClient (array $options = [], array $server = []): KernelBrowser
	{
		$server = array_merge($server, ['HTTP_HOST' => static::appId() . '.localhost']);

		return parent::createClient($options, $server);
	}
}
