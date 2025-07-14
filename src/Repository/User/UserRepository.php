<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 14/07/2025, 19:00
 *
 * @project IDMarinas Template Symfony
 * @see     https://github.com/idmarinas/template-symfony
 *
 * @file    UserRepository.php
 * @date    20/02/2025
 * @time    15:51
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.0.0
 */

namespace Core\Repository\User;

use Core\Entity\User\User;
use Core\Enums\Cache\CoreKeysEnum;
use Core\Enums\Cache\CoreTagsEnum;
use DateTime;
use Doctrine\Persistence\ManagerRegistry;
use Idm\Bundle\User\Model\Repository\AbstractUserRepository;
use Psr\Cache\InvalidArgumentException;
use Symfony\Component\DependencyInjection\Attribute\Target;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\Cache\TagAwareCacheInterface;

final class UserRepository extends AbstractUserRepository
{
	public function __construct (
		ManagerRegistry                         $registry,
		#[Target('idm.app.cache')]
		private readonly TagAwareCacheInterface $cache
	) {
		parent::__construct($registry, User::class);
	}

	/**
	 * @throws InvalidArgumentException
	 */
	public function countUserActives (bool $cache = true): int
	{
		$beta = $cache ? null : INF;

		return $this->cache->get(CoreKeysEnum::COUNT_USER_ACTIVE, function (ItemInterface $item): int {
			$item
				->expiresAt(new DateTime('+1 day'))
				->tag([
					CoreTagsEnum::ENTITY_COUNT,
					CoreTagsEnum::ENTITY_COUNT_ACTIVE,
					CoreTagsEnum::ENTITY_USER,
					CoreTagsEnum::ENTITY_COUNT_USER_ACTIVE,
				])
			;

			return $this
				->createQueryBuilder('u')
				->select('COUNT(u.id)')
				->where('u.inactive = :active AND u.deletedAt IS NULL')
				->setParameter('active', false)
				->getQuery()->getSingleScalarResult()
			;
		}, $beta);
	}
}
