<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 30/10/2025, 14:50
 *
 * @project IDMarinas Template Symfony
 * @see     https://github.com/idmarinas/template-symfony
 *
 * @file    rector.php
 * @date    25/08/2025
 * @time    19:49
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.0.0
 */

declare(strict_types=1);

use Rector\Config\RectorConfig;

return RectorConfig::configure()
	->withPaths([
		__DIR__ . '/apps',
		__DIR__ . '/config',
		__DIR__ . '/factories',
		__DIR__ . '/fixtures',
		__DIR__ . '/public',
		__DIR__ . '/src',
		__DIR__ . '/tests',
	])
	// uncomment to reach your current PHP version
	->withPhpSets(php84: true)
	->withPreparedSets(
		phpunitCodeQuality : true,
		doctrineCodeQuality: true,
		symfonyCodeQuality : true,
		symfonyConfigs     : true
	)
	->withTypeCoverageLevel(0)
	->withDeadCodeLevel(0)
	->withCodeQualityLevel(0)
	->withImportNames(importDocBlockNames: false, removeUnusedImports: true)
	->withComposerBased(twig: true, doctrine: true, symfony: true)
	->withSymfonyContainerXml(__DIR__ . '/var/cache/web/dev/Core_KernelDevDebugContainer.xml')
	->withSkip([
		__DIR__ . '/config/secrets',
		__DIR__ . '/config/bundles.php',
		__DIR__ . '/apps/*/config/bundles.php',
	])
;
