<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 21/02/2025, 16:42
 *
 * @project IDMarinas Template Symfony
 * @see     https://github.com/idmarinas/template-symfony
 *
 * @file    AdminLoginController.php
 * @date    21/02/2025
 * @time    16:40
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.0.0
 */

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

final class AdminLoginController extends AbstractController
{
	#[Route(path: '/login', name: 'login', methods: ['GET', 'POST'])]
	public function login (AuthenticationUtils $authenticationUtils): Response
	{
		if ($this->isGranted('ROLE_ADMIN')) {
			return $this->redirectToRoute('admin');
		}

		$error = $authenticationUtils->getLastAuthenticationError();

		// -- último nombre de usuario introducido por el usuario
		$lastUsername = $authenticationUtils->getLastUsername();

		return $this->render('@EasyAdmin/page/login.html.twig', [
			'error'                => $error,
			'last_username'        => $lastUsername,
			'page_title'           => 'IDMarinas Template Symfony Admin',
			'csrf_token_intention' => 'authenticate',
			'target_path'          => $this->generateUrl('admin'),
			'remember_me_enabled'  => true,
		]);
	}
}
