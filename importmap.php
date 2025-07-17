<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 07/03/2025, 15:31
 *
 * @project IDMarinas Template Symfony
 * @see     https://github.com/idmarinas/template-symfony
 *
 * @file    importmap.php
 * @date    07/05/2025
 * @time    22:07
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.0.0
 */

/**
 * Returns the importmap for this application.
 *
 * - "path" is a path inside the asset mapper system. Use the
 *     "debug:asset-map" command to see the full list of paths.
 *
 * - "entrypoint" (JavaScript only) set to true for any module that will
 *     be used as an "entrypoint" (and passed to the importmap() Twig function).
 *
 * The "importmap:require" command can be used to add new entries to this file.
 */
return [
	'app'                      => [
		'path'       => './assets/app.js',
		'entrypoint' => true,
	],
	'web'                               => [
		'path'       => './apps/web/assets/web.js',
		'entrypoint' => true,
	],
	'@hotwired/stimulus'       => [
		'version' => '3.2.2',
	],
	'@symfony/stimulus-bundle' => [
		'path' => './vendor/symfony/stimulus-bundle/assets/dist/loader.js',
	],
	'@hotwired/turbo'          => [
		'version' => '7.3.0',
	],
	'@stimulus-components/notification' => [
		'version' => '3.0.0',
	],
	'stimulus-use'                      => [
		'version' => '0.52.3',
	],
	'@stimulus-components/dialog'       => [
		'version' => '1.0.1',
	],
	'hotkeys-js'                        => [
		'version' => '3.13.14',
	],
	'@idmarinas/ui-bundle'              => [
		'path' => './vendor/idmarinas/ui-bundle/assets/dist/loader.js',
	],
];
