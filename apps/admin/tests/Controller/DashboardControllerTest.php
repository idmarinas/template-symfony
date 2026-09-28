<?php
/**
 * Copyright $originalComment.match("Copyright (\d+)", 1, "-",$today.year)2026 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 28/09/2026, 16:44
 *
 * @project IDMarinas Template Symfony
 * @see     https://github.com/idmarinas/template-symfony
 *
 * @file    DashboardControllerTest.php
 * @date    21/08/2025
 * @time    13:16
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.0.0
 */

declare(strict_types=1);

namespace Admin\Tests\Controller;

use Core\Tests\CreateClientTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;

final class DashboardControllerTest extends WebTestCase
{
	use CreateClientTrait;

	public function testDashboard(): void
	{
		$client = static::createClient();
		$client->request(Request::METHOD_GET, '/admin');

		$this->assertResponseStatusCodeSame(401);
	}
}
