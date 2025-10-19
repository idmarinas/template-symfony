<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 19/10/2025, 18:48
 *
 * @project IDMarinas Template Symfony
 * @see     https://github.com/idmarinas/template-symfony
 *
 * @file    ClearCacheSubscriber.php
 * @date    21/08/2025
 * @time    17:33
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.0.0
 */

namespace Core\Tests\PHPUnit\Extension;

use Core\Kernel;
use Override;
use PHPUnit\Event\TestSuite\Finished;
use PHPUnit\Event\TestSuite\FinishedSubscriber;
use Symfony\Component\Filesystem\Filesystem;

class ClearCacheSubscriber implements FinishedSubscriber
{
	#[Override]
	public function notify (Finished $event): void
	{
		$name = $event->testSuite()->name();
		if (!$event->testSuite()->isWithName() || str_contains($name, 'phpunit.xml')) {
			return;
		}

		$kernel = new Kernel('test', true, $name);
		$fs = new Filesystem();

		if ($fs->exists($kernel->getCacheDir())) {
			$fs->remove($kernel->getCacheDir());
		}

		if ($fs->exists($kernel->getLogDir())) {
			$fs->remove($kernel->getLogDir());
		}
	}
}
