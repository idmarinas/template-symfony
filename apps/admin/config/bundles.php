<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 30/06/2025, 17:11
 *
 * @project IDMarinas Template Symfony
 * @see     https://github.com/idmarinas/template-symfony
 *
 * @file    bundles.php
 * @date    02/03/2025
 * @time    18:11
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license undefined
 *
 * @since   1.0.0
 */

return [
	// Enabled necessary Bundles
	EasyCorp\Bundle\EasyAdminBundle\EasyAdminBundle::class                                              => ['all' => true],
	TalesFromADev\Twig\Extra\Tailwind\Bridge\Symfony\Bundle\TalesFromADevTwigExtraTailwindBundle::class => ['all' => true],
	// Disabled unnecessary Bundles
	Idm\Bundle\Common\IdmCommonBundle::class                                                            => ['all' => false],
	Idm\Bundle\Ui\IdmUiBundle::class                                                                    => ['all' => false],
];
