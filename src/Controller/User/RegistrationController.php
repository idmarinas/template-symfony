<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 20/02/2025, 15:51
 *
 * @project IDMarinas Template Symfony
 * @see     https://github.com/idmarinas/template-symfony
 *
 * @file    RegistrationController.php
 * @date    20/02/2025
 * @time    15:51
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.0.0
 */

namespace App\Controller\User;

use App\Form\User\RegistrationFormType;
use Idm\Bundle\User\Model\Controller\AbstractRegistrationController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
#[Route(path: '/registration', name: 'registration_')]
class RegistrationController extends AbstractRegistrationController
{
	protected function getRegistrationForm (?object $data = null, array $options = []): FormInterface
	{
		return $this->createForm(RegistrationFormType::class, $data, $options);
	}
}
