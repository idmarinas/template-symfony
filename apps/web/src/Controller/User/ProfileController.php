<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 03/03/2025, 20:23
 *
 * @project IDMarinas Template Symfony
 * @see     https://github.com/idmarinas/template-symfony
 *
 * @file    ProfileController.php
 * @date    20/02/2025
 * @time    15:51
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.0.0
 */

namespace Web\Controller\User;

use Idm\Bundle\User\Form\ChangePasswordFormType;
use Idm\Bundle\User\Model\Controller\AbstractProfileController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
#[Route(path: '/profile', name: 'profile_')]
class ProfileController extends AbstractProfileController
{
	protected function getChangePasswordForm (?object $data = null, array $options = []): FormInterface
	{
		return $this->createForm(ChangePasswordFormType::class, $data, $options);
	}
}
