<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 14/07/2025, 19:36
 *
 * @project IDMarinas Template Symfony
 * @see     https://github.com/idmarinas/template-symfony
 *
 * @file    ContactRepository.php
 * @date    20/02/2025
 * @time    18:09
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.0.0
 */

namespace Core\Repository\Feedback;

use Core\Entity\Feedback\Contact;
use Core\Enums\Cache\CoreKeysEnum;
use Core\Enums\Cache\CoreTagsEnum;
use DateTime;
use Doctrine\Persistence\ManagerRegistry;
use Idm\Bundle\Common\Model\Repository\AbstractContactRepository;
use Psr\Cache\InvalidArgumentException;
use Symfony\Component\DependencyInjection\Attribute\Target;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\Cache\TagAwareCacheInterface;

class ContactRepository extends AbstractContactRepository
{
	public function __construct (
		ManagerRegistry                         $registry,
		#[Target('idm.core.cache')]
		private readonly TagAwareCacheInterface $cache
	) {
		parent::__construct($registry, Contact::class);
	}

	/**
	 * @throws InvalidArgumentException
	 */
	public function countContactTotal (bool $cache = true): int
	{
		$beta = $cache ? null : INF;

		return $this->cache->get(CoreKeysEnum::COUNT_CONTACTS_TOTAL, function (ItemInterface $item): int {
			$item
				->expiresAt(new DateTime('+1 day'))
				->tag([
					CoreTagsEnum::ENTITY_COUNT,
					CoreTagsEnum::ENTITY_COUNT_TOTAL,
					CoreTagsEnum::ENTITY_CONTACT,
					CoreTagsEnum::ENTITY_COUNT_CONTACT_TOTAL,
				])
			;

			return $this
				->createQueryBuilder('u')
				->select('COUNT(u.id)')
				->getQuery()->getSingleScalarResult()
			;
		}, $beta);
	}
}
