<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 17/07/2025, 18:51
 *
 * @project IDMarinas Template Symfony
 * @see     https://github.com/idmarinas/template-symfony
 *
 * @file    bundles.php
 * @date    02/03/2025
 * @time    18:11
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.0.0
 */

return [
	// Enabled necessary Bundles
	EasyCorp\Bundle\EasyAdminBundle\EasyAdminBundle::class => ['all' => true],
	// Disabled unnecessary Bundles
	Idm\Bundle\Common\IdmCommonBundle::class               => ['all' => false],
];
