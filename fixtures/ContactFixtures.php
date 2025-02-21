<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 21/02/2025, 23:58
 *
 * @project IDMarinas Template Symfony
 * @see     https://github.com/idmarinas/template-symfony
 *
 * @file    ContactFixtures.php
 * @date    21/02/2025
 * @time    23:58
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.0.0
 */

namespace DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Factory\ContactFactory;

class ContactFixtures extends Fixture
{
	public function load (ObjectManager $manager): void
	{
		ContactFactory::createMany(50, ['email' => '']);
		ContactFactory::createMany(50);
	}
}
