<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 22/02/2025, 24:03
 *
 * @project IDMarinas Template Symfony
 * @see     https://github.com/idmarinas/template-symfony
 *
 * @file    UserFactory.php
 * @date    21/02/2025
 * @time    23:38
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.0.0
 */

namespace Factory;

use App\Entity\User\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

final class UserFactory extends PersistentProxyObjectFactory
{
	public function __construct (private readonly UserPasswordHasherInterface $hasher)
	{
		parent::__construct();
	}

	/**
	 * @inheritDoc
	 */
	public static function class (): string
	{
		return User::class;
	}

	protected function defaults (): array|callable
	{
		$createdAt = self::faker()->dateTime('-1 year');
		$updatedAt = self::faker()->dateTimeBetween($createdAt, '-1 day');

		return [
			'email'            => self::faker()->unique()->email(),
			'display_name'     => self::faker()->unique()->name(),
			'session_id'       => self::faker()->sha1(),
			'created_from_ip'  => self::faker()->ipv4(),
			'updated_from_ip'  => self::faker()->ipv4(),
			'last_connection'  => self::faker()->dateTimeBetween($createdAt, $updatedAt),
			'created_at'       => $createdAt,
			'updated_at'       => $updatedAt,
			'banned_until'     => self::faker()->dateTimeBetween('now', '+3 years'),
			'deleted_at'       => self::faker()->dateTimeBetween($createdAt),
			'privacy_accepted' => self::faker()->boolean(),
			'terms_accepted'   => self::faker()->boolean(),
			'verified'         => self::faker()->boolean(),
		];
	}

	protected function initialize (): static
	{
		return parent::initialize()
			->afterInstantiate(function (User $user): void {
				$user->setPassword($this->hasher->hashPassword($user, $user->getPassword()));
			})
		;
	}
}
