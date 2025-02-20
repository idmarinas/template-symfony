<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 20/02/2025, 15:51
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

namespace App\Controller\User;

use Idm\Bundle\User\Form\ChangePasswordFormType;
use Idm\Bundle\User\Model\Controller\AbstractProfileController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[AsController]
#[IsGranted('IS_AUTHENTICATED_FULLY')]
#[Route(path: '/profile', name: 'profile_')]
class ProfileController extends AbstractProfileController
{
	protected function getChangePasswordForm (?object $data = null, array $options = []): FormInterface
	{
		return $this->createForm(ChangePasswordFormType::class, $data, $options);
	}
}
