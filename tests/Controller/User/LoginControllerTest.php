<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 23/02/2025, 19:39
 *
 * @project IDMarinas Template Symfony
 * @see     https://github.com/idmarinas/template-symfony
 *
 * @file    LoginControllerTest.php
 * @date    22/02/2025
 * @time    12:05
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.0.0
 */

namespace App\Tests\Controller\User;

use App\Repository\User\UserRepository;
use DataFixtures\User\UserFixtures;
use Doctrine\Common\Collections\Criteria;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;

class LoginControllerTest extends WebTestCase
{
	public function testLogin (): void
	{
		$client = static::createClient();
		$client->request(Request::METHOD_GET, '/user/login/web');

		$this->assertResponseIsSuccessful();

		$this->assertPageTitleContains('Login');

		$client->submitForm('Connect', [
			'_username' => 'john.doe@example.com',
			'_password' => UserFixtures::USER_PASS,
		]);

		$this->assertResponseRedirects('/user/profile');

		$client->followRedirect();
		$this->assertResponseIsSuccessful();
		$this->assertPageTitleContains('Profile of John');

		$client->request(Request::METHOD_GET, '/user/login/web');

		$this->assertResponseRedirects('/user/profile');
	}

	public function testLoginInvalid (): void
	{
		$client = static::createClient();
		$client->request(Request::METHOD_GET, '/user/login/web');

		$this->assertResponseIsSuccessful();

		$this->assertPageTitleContains('Login');

		$client->submitForm('Connect', [
			'_username' => 'john.doe@example.com',
			'_password' => UserFixtures::USER_PASS . 'dfDyt',
		]);

		$this->assertResponseRedirects('/user/login/web');
		$client->followRedirect();

		$this->assertSelectorTextContains('form', 'Invalid credentials.');
	}

	public function testLoginChecker (): void
	{
		$client = static::createClient();
		/* @var UserRepository $repository */
		$repository = static::getContainer()->get(UserRepository::class);

		$client->request(Request::METHOD_GET, '/user/login/web');

		$this->assertPageTitleContains('Login');

		/**
		 * User Banned
		 */
		$user = $repository->matching(
			Criteria::create()
				->where(Criteria::expr()->neq('bannedUntil', null))
				->andWhere(Criteria::expr()->isNull('deletedAt'))
				->setMaxResults(1)
		)->first();

		$client->submitForm('Connect', [
			'_username' => $user->getEmail(),
			'_password' => UserFixtures::USER_PASS,
		]);

		$this->assertResponseRedirects('/user/login/web');
		$client->followRedirect();

		$this->assertSelectorTextContains('form', 'Your user account has been banned');

		/**
		 * User Deleted
		 */
		$user = $repository->matching(
			Criteria::create()
				->where(Criteria::expr()->neq('deletedAt', null))
				->andWhere(Criteria::expr()->isNull('bannedUntil'))
				->setMaxResults(1)
		)->first();

		$client->submitForm('Connect', [
			'_username' => $user->getEmail(),
			'_password' => UserFixtures::USER_PASS,
		]);

		$this->assertResponseRedirects('/user/login/web');
		$client->followRedirect();

		$this->assertSelectorTextContains('form', 'Your user account no longer exists');

		/**
		 * User Unverified
		 */
		$user = $repository->matching(
			Criteria::create()
				->where(Criteria::expr()->isNull('deletedAt'))
				->andWhere(Criteria::expr()->isNull('bannedUntil'))
				->andWhere(Criteria::expr()->eq('verified', false))
				->setMaxResults(1)
		)->first();

		$client->submitForm('Connect', [
			'_username' => $user->getEmail(),
			'_password' => UserFixtures::USER_PASS,
		]);

		$this->assertResponseRedirects('/user/profile');
		$client->followRedirect();

		$this->assertSelectorTextContains('body', 'You need to verify your email address');
	}
}
