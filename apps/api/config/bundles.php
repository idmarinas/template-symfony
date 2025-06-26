<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "idmarinas" on 19/06/2025, 18:59
 *
 * @project IDMarinas Template Symfony
 * @see     https://github.com/idmarinas/template-symfony
 *
 * @file    bundles.php
 * @date    13/03/2025
 * @time    22:56
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.0.0
 */

return [
	// Enabled necessary Bundles
	// Disabled unnecessary Bundles
	Idm\Bundle\Ui\IdmUiBundle::class                          => ['all' => false],
	Symfony\Bundle\TwigBundle\TwigBundle::class               => ['all' => false],
	Symfony\UX\StimulusBundle\StimulusBundle::class           => ['all' => false],
	Symfony\UX\Turbo\TurboBundle::class                       => ['all' => false],
	Symfony\UX\TwigComponent\TwigComponentBundle::class       => ['all' => false],
	Symfony\UX\Icons\UXIconsBundle::class                     => ['all' => false],
	Symfony\Bundle\WebProfilerBundle\WebProfilerBundle::class => ['all' => false],
	Twig\Extra\TwigExtraBundle\TwigExtraBundle::class         => ['all' => false],
];
