<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 20/02/2025, 15:51
 *
 * @project IDMarinas Template Symfony
 * @see     https://github.com/idmarinas/template-symfony
 *
 * @file    ResetPasswordController.php
 * @date    20/02/2025
 * @time    15:51
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.0.0
 */

namespace App\Controller\User;

use Idm\Bundle\User\Form\ResetPasswordFormType;
use Idm\Bundle\User\Form\ResetPasswordRequestFormType;
use Idm\Bundle\User\Model\Controller\AbstractResetPasswordController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
#[Route('/reset-password')]
class ResetPasswordController extends AbstractResetPasswordController
{
	protected function getResetPasswordRequestForm (?object $data = null, array $options = []): FormInterface
	{
		return $this->createForm(ResetPasswordRequestFormType::class, $data, $options);
	}

	protected function getResetPasswordForm (?object $data = null, array $options = []): FormInterface
	{
		return $this->createForm(ResetPasswordFormType::class, $data, $options);
	}
}
