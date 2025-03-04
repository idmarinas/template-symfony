<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 03/03/2025, 20:23
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

namespace Web\Controller\Public;

use Doctrine\ORM\EntityManagerInterface;
use Idm\Bundle\Common\Model\Controller\AbstractContactController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Web\Form\Contact\ContactFormType;

#[Route('/contact', name: 'contact_')]
class ContactController extends AbstractContactController
{
	#[Route(path: '/web', name: 'web', methods: ['GET', 'POST'])]
	public function index (Request $request, EntityManagerInterface $entityManager): Response
	{
		return parent::index($request, $entityManager);
	}

	protected function getContactForm (): FormInterface
	{
		return $this->createForm(ContactFormType::class);
	}
}
