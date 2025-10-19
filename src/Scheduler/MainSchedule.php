<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 19/10/2025, 20:15
 *
 * @project IDMarinas Template Symfony
 * @see     https://github.com/idmarinas/template-symfony
 *
 * @file    MainSchedule.php
 * @date    19/10/2025
 * @time    20:00
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.0.0
 */

namespace Core\Scheduler;

use Symfony\Component\DependencyInjection\Attribute\Target;
use Symfony\Component\Lock\LockFactory;
use Symfony\Component\Scheduler\Attribute\AsSchedule;
use Symfony\Component\Scheduler\Schedule;
use Symfony\Component\Scheduler\ScheduleProviderInterface;
use Symfony\Contracts\Cache\CacheInterface;

#[AsSchedule]
final readonly class MainSchedule implements ScheduleProviderInterface
{
	public function __construct (
		#[Target('scheduler.cache')]
		private CacheInterface $cache,
		private LockFactory    $lockFactory
	) {}

	public function getSchedule (): Schedule
	{
		return new Schedule()
			->stateful($this->cache) // ensure missed tasks are executed
			->lock($this->lockFactory->createLock('scheduler_default'))
			->processOnlyLastMissedRun(true) // ensure only last missed task is run

			// add your own tasks here
			// see https://symfony.com/doc/current/scheduler.html#attaching-recurring-messages-to-a-schedule
			;
	}
}
