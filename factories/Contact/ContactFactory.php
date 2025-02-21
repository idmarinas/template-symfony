<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 22/02/2025, 24:14
 *
 * @project IDMarinas Template Symfony
 * @see     https://github.com/idmarinas/template-symfony
 *
 * @file    ContactFactory.php
 * @date    22/01/2025
 * @time    13:14
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   3.4.0
 */

namespace Factory\Contact;

use App\Entity\Contact\Contact;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Contact>
 */
final class ContactFactory extends PersistentProxyObjectFactory
{
	public static function class (): string
	{
		return Contact::class;
	}

	/**
	 * @see  https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
	 */
	protected function defaults (): array|callable
	{
		$createdAt = self::faker()->dateTime('-1 year');
		$updatedAt = self::faker()->dateTimeBetween($createdAt, '-1 day');

		return [
			'comment'   => self::faker()->text(),
			'consent'   => self::faker()->boolean(),
			'email'     => self::faker()->email(),
			'lastName'  => self::faker()->lastName(),
			'name'      => self::faker()->firstName(),
			'createdAt' => $createdAt,
			'updatedAt' => $updatedAt,
		];
	}

	/**
	 * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
	 */
	protected function initialize (): static
	{
		return $this// ->afterInstantiate(function(Contact $contact): void {})
			;
	}
}
