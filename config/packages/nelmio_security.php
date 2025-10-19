<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 19/10/2025, 18:48
 *
 * @project IDMarinas Template Symfony
 * @see     https://github.com/idmarinas/template-symfony
 *
 * @file    nelmio_security.php
 * @date    30/06/2025
 * @time    17:33
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.0.0
 */

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Symfony\Component\DependencyInjection\ContainerBuilder;

return static function (ContainerConfigurator $container, ContainerBuilder $builder): void {
	if (!$builder->hasExtension('nelmio_security')) {
		return;
	}

	$container->extension('nelmio_security', [
		// prevents framing of the entire site
		'clickjacking'       => [
			'paths' => [
				'^/.*' => 'DENY',
			],
		],
		// disables content type sniffing for script resources
		'content_type'       => [
			'nosniff' => true,
		],
		// prevents redirections outside the website's domain
		'external_redirects' => [
			'log'        => true,
			'override'   => '/external-redirect',
			'forward_as' => 'redirUrl',
			'allow_list' => [],
		],
		/**
		 * Send a full URL in the `Referer` header when performing a same-origin request,
		 * only send the origin of the document to secure destination (HTTPS->HTTPS),
		 * and send no header to a less secure destination (HTTPS->HTTP).
		 * If `strict-origin-when-cross-origin` is not supported, use `no-referrer` policy,
		 * no referrer information is sent along with requests.
		 */
		'referrer_policy'    => [
			'enabled'  => true,
			'policies' => [
				'no-referrer',
				'same-origin',
				'strict-origin',
				'strict-origin-when-cross-origin',
			],
		],
		'csp'                => [
			'enabled'               => true,
			'report_logger_service' => 'monolog.logger.csp',
			'hosts'                 => [],
			'content-types'         => [],
			'enforce'               => [
				'level1_fallback'           => true,
				'browser_adaptive'          => [
					'enabled' => false,
				],
				'report-uri'                => '%router.request_context.base_url%/nelmio/csp/report',
				'block-all-mixed-content'   => true, # defaults to false, blocks HTTP content over HTTPS transport
				'upgrade-insecure-requests' => true, # defaults to false, upgrades HTTP requests to HTTPS transport
				'base-uri'                  => ['self'],
				'manifest-src'              => ['self'],
				'frame-ancestors'           => ['self'],
				'object-src'                => ['none'],
				'frame-src'                 => ['self'],
				'form-action'               => ['self'],
				'connect-src'               => ['self'],
				'img-src'                   => ['self', 'data:'],
				'font-src'                  => ['self'],
			],
			'report_endpoint'       => [
				'log_level' => 'notice',
				'filters'   => [
					'domains'          => true,
					'schemes'          => true,
					'browser_bugs'     => true,
					'injected_scripts' => false,
				],
			],
		],
	]);

	if ('prod' === $container->env()) {
		$container->extension('nelmio_security', [
			'csp' => [
				'report' => [
					'level1_fallback'  => true,
					'browser_adaptive' => [
						'enabled' => true,
					],
					'report-uri'       => '%router.request_context.base_url%/nelmio/csp/report',
					'default-src'      => ['self'],
				],
			],
		]);
	}
};
