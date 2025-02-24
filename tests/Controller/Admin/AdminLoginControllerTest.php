<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 24/02/2025, 17:06
 *
 * @project IDMarinas Template Symfony
 * @see     https://github.com/idmarinas/template-symfony
 *
 * @file    AdminLoginControllerTest.php
 * @date    23/02/2025
 * @time    19:38
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.0.0
 */

namespace App\Tests\Controller\Admin;

use DataFixtures\User\UserFixtures;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;

class AdminLoginControllerTest extends WebTestCase
{

	public function testUserCheckAdmin (): void
	{
		$client = static::createClient();
		$client->request(Request::METHOD_GET, '/panel/admin/login');

		$this->assertResponseIsSuccessful();

		$client->submitForm('Sign in', [
			'_username' => UserFixtures::USER_EMAIL,
			'_password' => UserFixtures::USER_PASS,
		]);

		$this->assertResponseRedirects('/panel/admin/login');
		$client->followRedirect();

		$this->assertResponseIsSuccessful();
	}

	public function testLoginAdmin (): void
	{
		$client = static::createClient();
		$client->request(Request::METHOD_GET, '/panel/admin/login');

		$client->submitForm('Sign in', [
			'_username' => UserFixtures::USER_ADMIN_EMAIL,
			'_password' => UserFixtures::USER_PASS,
		]);

		$this->assertResponseRedirects('/panel/admin');

		$client->followRedirect();

		$this->assertResponseIsSuccessful();
	}

	public function testAdminRedirectToPanel (): void
	{
		$client = static::createClient();
		$client->request(Request::METHOD_GET, '/panel/admin/login');

		$client->submitForm('Sign in', [
			'_username' => UserFixtures::USER_ADMIN_EMAIL,
			'_password' => UserFixtures::USER_PASS,
		]);

		$client->followRedirect();

		// test if when is authenticated redirect to admin panel
		$client->request(Request::METHOD_GET, '/panel/admin/login');

		$this->assertResponseRedirects('/panel/admin');
		$client->followRedirect();
	}
}
