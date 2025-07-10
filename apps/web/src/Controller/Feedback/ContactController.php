<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 10/07/2025, 20:10
 *
 * @project IDMarinas Template Symfony
 * @see     https://github.com/idmarinas/template-symfony
 *
 * @file    ContactController.php
 * @date    10/07/2025
 * @time    20:01
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.0.0
 */

namespace Web\Controller\Feedback;

use Doctrine\ORM\EntityManagerInterface;
use Idm\Bundle\Common\Model\Controller\AbstractContactController;
use Override;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Web\Form\Feedback\ContactFormType;

#[Route('/contact', name: 'contact_')]
class ContactController extends AbstractContactController
{
	#[Route(path: '/', name: 'index', methods: ['GET', 'POST'])]
	#[Override]
	public function index (Request $request, EntityManagerInterface $entityManager): Response
	{
		return parent::index($request, $entityManager);
	}

	protected function getContactForm (): FormInterface
	{
		return $this->createForm(ContactFormType::class);
	}
}
