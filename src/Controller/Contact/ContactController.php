<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 20/02/2025, 18:08
 *
 * @project IDMarinas Template Symfony
 * @see     https://github.com/idmarinas/template-symfony
 *
 * @file    ContactController.php
 * @date    20/02/2025
 * @time    18:08
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.0.0
 */

namespace App\Controller\Contact;

use App\Form\Contact\ContactFormType;
use Idm\Bundle\Common\Model\Controller\AbstractContactController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/contact', name: 'contact')]
class ContactController extends AbstractContactController
{
	protected function getContactForm (): FormInterface
	{
		return $this->createForm(ContactFormType::class);
	}
}
