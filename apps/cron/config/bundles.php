<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 09/07/2025, 16:03
 *
 * @project IDMarinas Template Symfony
 * @see     https://github.com/idmarinas/template-symfony
 *
 * @file    bundles.php
 * @date    25/03/2025
 * @time    23:47
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license undefined
 *
 * @since   1.0.0
 */

return [
	// Enabled necessary Bundles
	// Disabled unnecessary Bundles
	Doctrine\Bundle\MigrationsBundle\DoctrineMigrationsBundle::class => ['all' => false],
	Nelmio\SecurityBundle\NelmioSecurityBundle::class                => ['all' => false],
	Idm\Bundle\Ui\IdmUiBundle::class                                 => ['all' => false],
	Symfony\Bundle\TwigBundle\TwigBundle::class                      => ['all' => false],
	Symfony\UX\StimulusBundle\StimulusBundle::class                  => ['all' => false],
	Symfony\UX\Turbo\TurboBundle::class                              => ['all' => false],
	Symfony\UX\TwigComponent\TwigComponentBundle::class              => ['all' => false],
	Symfony\UX\Icons\UXIconsBundle::class                            => ['all' => false],
	Symfony\Bundle\WebProfilerBundle\WebProfilerBundle::class        => ['all' => false],
	Twig\Extra\TwigExtraBundle\TwigExtraBundle::class                => ['all' => false],
];
