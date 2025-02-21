<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 21/02/2025, 17:01
 *
 * @project IDMarinas Template Symfony
 * @see     https://github.com/idmarinas/template-symfony
 *
 * @file    CspSubscriber.php
 * @date    20/02/2025
 * @time    22:40
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.0.0
 */

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Temporary “fix” to resolve EasyAdminBundle incompatibility with CSP
 */
final class CspSubscriber implements EventSubscriberInterface
{
	public static function getSubscribedEvents (): array
	{
		return [
			KernelEvents::RESPONSE => ['onKernelResponse', -100],
		];
	}

	public function onKernelResponse (ResponseEvent $event): void
	{
		$attributes = $event->getRequest()->attributes;

		if (!$event->isMainRequest()
		    || ($attributes->has('routeCreatedByEasyAdmin') && !$attributes->get('routeCreatedByEasyAdmin'))
		    || $attributes->get('_route') != 'admin_login') {
			return;
		}

		$headers = $event->getResponse()->headers;

		if ($headers->has('Content-Security-Policy')) {
			$csp = $headers->get('Content-Security-Policy');
			$csp = preg_replace('/script-src(.)*;/mi', '', $csp);

			$headers->set('Content-Security-Policy', $csp);
		}
	}
}
