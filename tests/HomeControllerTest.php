<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 19/10/2025, 18:48
 *
 * @project IDMarinas Template Symfony
 * @see     https://github.com/idmarinas/template-symfony
 *
 * @file    HomeControllerTest.php
 * @date    23/02/2025
 * @time    19:38
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.0.0
 */

namespace Core\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;

class HomeControllerTest extends WebTestCase
{
	use CreateClientTrait;

	public function testHomePage (): void
	{
		$client = static::createClient();
		$client->request(Request::METHOD_GET, '/');

		$this->assertResponseStatusCodeSame(404);
	}
}
