<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 19/10/2025, 18:11
 *
 * @project IDMarinas Template Symfony
 * @see     https://github.com/idmarinas/template-symfony
 *
 * @file    LoginControllerTest.php
 * @date    23/02/2025
 * @time    19:38
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.0.0
 */

namespace Admin\Tests\Controller;

use Core\Tests\CreateClientTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;

class LoginControllerTest extends WebTestCase
{
	use CreateClientTrait;

	public function testLoginUser (): void
	{
		$client = static::createClient();
		$client->request(Request::METHOD_GET, '/admin/login');

		$this->assertResponseIsSuccessful();

		$client->submitForm('Sign in', [
			'_username' => 'admin@admin.admin',
			'_password' => 'admin.pass.1234.uj',
		]);

		$this->assertResponseIsSuccessful();
	}
}
