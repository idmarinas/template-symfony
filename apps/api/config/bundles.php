<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 25/08/2025, 20:03
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
	// Active only for Dev/Test
	Symfony\Bundle\TwigBundle\TwigBundle::class                      => ['dev' => true, 'test' => true],
	Twig\Extra\TwigExtraBundle\TwigExtraBundle::class                => ['dev' => true, 'test' => true],
	Symfony\UX\TwigComponent\TwigComponentBundle::class              => ['dev' => true, 'test' => true],
	// Disable unnecessary Bundles
	Doctrine\Bundle\MigrationsBundle\DoctrineMigrationsBundle::class => ['all' => false],
	Symfony\UX\StimulusBundle\StimulusBundle::class                  => ['all' => false],
	Symfony\UX\Turbo\TurboBundle::class                              => ['all' => false],
];
