<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 22/02/2025, 11:59
 *
 * @project IDMarinas Template Symfony
 * @see     https://github.com/idmarinas/template-symfony
 *
 * @file    UserTest.php
 * @date    22/02/2025
 * @time    24:20
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.0.0
 */

namespace App\Tests\Entity\User;

use Factory\User\UserFactory;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Zenstruck\Foundry\Test\Factories;

class UserTest extends KernelTestCase
{
	use Factories;

	public function testEntity (): void
	{
		$entity = UserFactory::new()->create();

		UserFactory::assert()->exists($entity);
		UserFactory::assert()->count(203);

		$entity->_delete();

		UserFactory::assert()->count(202);
	}
}
