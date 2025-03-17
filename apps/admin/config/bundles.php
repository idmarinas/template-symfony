<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 13/03/2025, 22:36
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
	EasyCorp\Bundle\EasyAdminBundle\EasyAdminBundle::class => ['all' => true],
	Idm\Bundle\Common\IdmCommonBundle::class               => ['all' => false],
	Idm\Bundle\Ui\IdmUiBundle::class                       => ['all' => false], // Change to true if you need in Admin
];
