<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 18/03/2025, 16:40
 *
 * @project IDMarinas Template Symfony
 * @see     https://github.com/idmarinas/template-symfony
 *
 * @file    UserCrudControllerTest.php
 * @date    27/02/2025
 * @time    15:28
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.0.0
 */

namespace Admin\Tests\Controller\User;

use Admin\Controller\DashboardController;
use Admin\Controller\User\UserCrudController;
use DataFixtures\User\UserFixtures;
use Doctrine\Common\Collections\Criteria;
use EasyCorp\Bundle\EasyAdminBundle\Test\AbstractCrudTestCase;
use Factory\User\UserFactory;
use Shared\Entity\User\User;
use Shared\Repository\User\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Zenstruck\Foundry\Test\Factories;
use function Symfony\Component\String\u;

class UserCrudControllerTest extends AbstractCrudTestCase
{
	use Factories;

	public function testAuthorizationPage ()
	{
		$this->client->request(Request::METHOD_GET, $this->generateIndexUrl());

		$this->assertResponseRedirects('/panel/admin/login');

		$this->client->followRedirect();

		$this->assertResponseIsSuccessful();
	}

	public function testIndexPage ()
	{
		$user = UserFactory::find(['email' => UserFixtures::USER_ADMIN_EMAIL])->_real();

		$this->client->loginUser($user, 'admin');

		$this->client->request(Request::METHOD_GET, $this->generateIndexUrl());

		$this->assertResponseIsSuccessful();
	}

	public function testRestoreEntityInsufficientPermission ()
	{
		$user = UserFactory::find(['email' => UserFixtures::USER_ADMIN_EMAIL])->_real();

		$this->client->loginUser($user, 'admin');
		$this->client->request(Request::METHOD_GET, $this->generateIndexUrl());

		$actionRestore = $this->getActionSelector('restore');
		$crawler = $this->client->getCrawler();
		$restore = $crawler->filter($actionRestore);

		$this->assertCount(0, $restore);

		$entity = $this->getDeletedEntity();
		$urlRestore = $this->getCrudUrl(
			action        : 'restore',
			entityId      : $entity->getId(),
			controllerFqcn: UserCrudController::class
		);

		$this->client->request(Request::METHOD_GET, $urlRestore);

		$this->assertResponseStatusCodeSame(403);
	}

	public function testRestoreEntity ()
	{
		$user = UserFactory::find(['email' => UserFixtures::USER_SUPER_ADMIN_EMAIL])->_real();

		$this->client->loginUser($user, 'admin');
		$this->client->request(Request::METHOD_GET, $this->generateIndexUrl());

		$actionRestore = $this->getActionSelector('restore');
		$crawler = $this->client->getCrawler();
		$restore = $crawler->filter($actionRestore)->first();
		$restoreLink = $restore->link();

		$this->assertCount(1, $restore);

		$this->client->click($restoreLink);

		$this->assertResponseRedirects('/panel/admin/user');
		$this->client->followRedirect();

		$entityId = u($restoreLink->getUri())->beforeLast('/')->afterLast('/')->toString();

		dump($entityId);

		$this->assertIndexEntityActionNotExists('restore', $entity->getId());

		dump($this->client->getResponse()->getContent());
	}

	protected function getControllerFqcn (): string
	{
		return UserCrudController::class;
	}

	protected function getDashboardFqcn (): string
	{
		return DashboardController::class;
	}

	private function getDeletedEntity (): User
	{
		$repository = static::getContainer()->get(UserRepository::class);

		return $repository->matching(
			Criteria::create()
				->where(Criteria::expr()->neq('deletedAt', null))
				->andWhere(Criteria::expr()->isNull('bannedUntil'))
				->setMaxResults(1)
		)->first();
	}
}
