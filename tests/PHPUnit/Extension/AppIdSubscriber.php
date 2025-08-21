<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 21/08/2025, 16:51
 *
 * @project IDMarinas Template Symfony
 * @see     https://github.com/idmarinas/template-symfony
 *
 * @file    AppIdSubscriber.php
 * @date    21/08/2025
 * @time    15:44
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.0.0
 */

namespace Core\Tests\PHPUnit\Extension;

use Override;
use PHPUnit\Event\TestSuite\Started;
use PHPUnit\Event\TestSuite\StartedSubscriber;
use Symfony\Component\Dotenv\Dotenv;

class AppIdSubscriber implements StartedSubscriber
{
	#[Override]
	public function notify (Started $event): void
	{
		$name = $event->testSuite()->name();
		if (!$event->testSuite()->isWithName() || str_contains($name, 'phpunit.xml')) {
			return;
		}

		new Dotenv()->populate(['APP_ID' => $name]);
	}
}
