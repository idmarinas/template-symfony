<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 24/02/2025, 17:54
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

namespace App\Controller\Public;

use App\Form\Contact\ContactFormType;
use Doctrine\ORM\EntityManagerInterface;
use Idm\Bundle\Common\Model\Controller\AbstractContactController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

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
