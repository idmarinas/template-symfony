<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 30/06/2025, 17:09
 *
 * @project IDMarinas Template Symfony
 * @see     https://github.com/idmarinas/template-symfony
 *
 * @file    bundles.php
 * @date    13/03/2025
 * @time    22:56
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license undefined
 *
 * @since   1.0.0
 */

return [
	// Active only for Dev
	Symfony\Bundle\TwigBundle\TwigBundle::class                      => ['dev' => true],
	Twig\Extra\TwigExtraBundle\TwigExtraBundle::class                => ['dev' => true],
	// Disable unnecessary Bundles
	Doctrine\Bundle\MigrationsBundle\DoctrineMigrationsBundle::class => ['all' => false],
	Idm\Bundle\Ui\IdmUiBundle::class                                 => ['all' => false],
	Symfony\UX\StimulusBundle\StimulusBundle::class                  => ['all' => false],
	Symfony\UX\Turbo\TurboBundle::class                              => ['all' => false],
	Symfony\UX\TwigComponent\TwigComponentBundle::class              => ['all' => false],
	Symfony\UX\Icons\UXIconsBundle::class                            => ['all' => false],
];
