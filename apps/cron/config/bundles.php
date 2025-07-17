<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 17/07/2025, 18:52
 *
 * @project IDMarinas Template Symfony
 * @see     https://github.com/idmarinas/template-symfony
 *
 * @file    bundles.php
 * @date    25/03/2025
 * @time    23:47
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.0.0
 */

return [
	// Enabled necessary Bundles
	// Disabled unnecessary Bundles
	Doctrine\Bundle\MigrationsBundle\DoctrineMigrationsBundle::class => ['all' => false],
	Nelmio\SecurityBundle\NelmioSecurityBundle::class                => ['all' => false],
	Symfony\Bundle\TwigBundle\TwigBundle::class                      => ['all' => false],
	Symfony\UX\StimulusBundle\StimulusBundle::class                  => ['all' => false],
	Symfony\UX\Turbo\TurboBundle::class                              => ['all' => false],
	Symfony\UX\TwigComponent\TwigComponentBundle::class              => ['all' => false],
	Symfony\Bundle\WebProfilerBundle\WebProfilerBundle::class        => ['all' => false],
	Twig\Extra\TwigExtraBundle\TwigExtraBundle::class                => ['all' => false],
];
