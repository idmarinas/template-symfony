<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 17/07/2025, 19:33
 *
 * @project IDMarinas Template Symfony
 * @see     https://github.com/idmarinas/template-symfony
 *
 * @file    bundles.php
 * @date    08/07/2025
 * @time    18:02
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.0.0
 */

return [
	Symfony\Bundle\FrameworkBundle\FrameworkBundle::class             => ['all' => true],
	Doctrine\Bundle\DoctrineBundle\DoctrineBundle::class              => ['all' => true],
	Doctrine\Bundle\MigrationsBundle\DoctrineMigrationsBundle::class  => ['all' => true],
	Symfony\Bundle\DebugBundle\DebugBundle::class                     => ['dev' => true],
	Symfony\Bundle\TwigBundle\TwigBundle::class                       => ['all' => true],
	Symfony\Bundle\WebProfilerBundle\WebProfilerBundle::class         => ['dev' => true, 'test' => true],
	Symfony\UX\StimulusBundle\StimulusBundle::class                   => ['all' => true],
	Symfony\UX\Turbo\TurboBundle::class                               => ['all' => true],
	Twig\Extra\TwigExtraBundle\TwigExtraBundle::class                 => ['all' => true],
	Symfony\Bundle\SecurityBundle\SecurityBundle::class               => ['all' => true],
	Symfony\Bundle\MonologBundle\MonologBundle::class                 => ['all' => true],
	Symfony\Bundle\MakerBundle\MakerBundle::class                     => ['dev' => true],
	Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle::class      => ['dev' => true, 'test' => true],
	Symfonycasts\TailwindBundle\SymfonycastsTailwindBundle::class     => ['dev' => true],
	Zenstruck\Foundry\ZenstruckFoundryBundle::class                   => ['dev' => true, 'test' => true],
	DAMA\DoctrineTestBundle\DAMADoctrineTestBundle::class             => ['test' => true],
	Symfony\UX\TwigComponent\TwigComponentBundle::class               => ['all' => true],
	Stof\DoctrineExtensionsBundle\StofDoctrineExtensionsBundle::class => ['all' => true],
	Nelmio\SecurityBundle\NelmioSecurityBundle::class                 => ['all' => true],
	Idm\Bundle\Maker\IdmMakerBundle::class                            => ['dev' => true, 'test' => true],
];
