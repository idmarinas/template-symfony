<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 18/03/2025, 14:35
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
	Symfony\Bundle\TwigBundle\TwigBundle::class               => ['all' => false],
	Twig\Extra\TwigExtraBundle\TwigExtraBundle::class         => ['all' => false],
	Symfony\UX\StimulusBundle\StimulusBundle::class           => ['all' => false],
	Symfony\UX\Turbo\TurboBundle::class                       => ['all' => false],
	Symfony\UX\TwigComponent\TwigComponentBundle::class       => ['all' => false],
	Symfony\UX\Icons\UXIconsBundle::class                     => ['all' => false],
	Idm\Bundle\Ui\IdmUiBundle::class                          => ['all' => false],
	Symfony\Bundle\WebProfilerBundle\WebProfilerBundle::class => ['all' => false],
];
