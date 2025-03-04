<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 03/03/2025, 20:23
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

namespace Web\Controller\User;

use Idm\Bundle\User\Model\Controller\AbstractRegistrationController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;
use Web\Form\User\RegistrationFormType;

#[AsController]
#[Route(path: '/registration', name: 'registration_')]
class RegistrationController extends AbstractRegistrationController
{
	protected function getRegistrationForm (?object $data = null, array $options = []): FormInterface
	{
		return $this->createForm(RegistrationFormType::class, $data, $options);
	}
}
