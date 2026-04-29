<?php

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
			'report'                => [
				'level1_fallback'           => true,
				'browser_adaptive'          => [
					'enabled' => false,
				],
				'report-uri'                => '%router.request_context.base_url%/nelmio/csp/report',
				'block-all-mixed-content'   => true, # defaults to false, blocks HTTP content over HTTPS transport
				'upgrade-insecure-requests' => true, # defaults to false, upgrades HTTP requests to HTTPS transport
				'base-uri'                  => ['none'],
				'manifest-src'              => ['self'],
				'object-src'                => ['none'],
				'style-src'                 => ['self', 'data:'],
				'script-src'                => ['self', 'unsafe-inline', 'unsafe-eval', 'strict-dynamic', 'https:', 'http:'],
			],
			'report_endpoint'       => [
				'log_level'   => 'notice',
				'log_channel' => 'csp',
				'filters'     => [
					'domains'          => true,
					'schemes'          => true,
					'browser_bugs'     => true,
					'injected_scripts' => false,
				],
			],
		],
		'permissions_policy' => [
			'enabled'  => true,
			'policies' => [
				// Media permissions
				'camera'                    => [],
				'microphone'                => [],

				// Location and sensors
				'geolocation'               => [],
				'accelerometer'             => [],
				'gyroscope'                 => [],
				'magnetometer'              => [],

				// Privacy features
				// 'interest_cohort'           => [], # Disable FLoC tracking

				// Payment and authentication
				'payment'                   => ['self'],
				'publickey_credentials_get' => ['self'],

				// Display and interaction
				'fullscreen'                => ['self'],
				'picture_in_picture'        => ['self'],
				'autoplay'                  => [],

				// Disable Topics tracking if not enabled explicitly: https://github.com/jkarlin/topics
				// 'browsing_topics'           => [],
			],
		],
	]);

	if ('dev' === $container->env()) {
		$container->extension('nelmio_security', [
			'csp' => [
				'report' => [
					'style-src' => ['unsafe-inline'],
				],
			],
		]);
	}
};
