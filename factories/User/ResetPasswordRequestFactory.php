<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 18/03/2025, 16:40
 *
 * @project IDMarinas Template Symfony
 * @see     https://github.com/idmarinas/template-symfony
 *
 * @file    ResetPasswordRequestFactory.php
 * @date    22/02/2025
 * @time    24:12
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.0.0
 */

namespace Factory\User;

use DateTimeImmutable;
use Shared\Entity\User\ResetPasswordRequest;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<ResetPasswordRequest>
 */
final class ResetPasswordRequestFactory extends PersistentProxyObjectFactory
{
	public static function class (): string
	{
		return ResetPasswordRequest::class;
	}

	/**
	 * @see  https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
	 *
	 * @todo add your default values here
	 */
	protected function defaults (): array|callable
	{
		return [
			'expiresAt'   => DateTimeImmutable::createFromMutable(self::faker()->dateTime()),
			'hashedToken' => self::faker()->text(100),
			'requestedAt' => DateTimeImmutable::createFromMutable(self::faker()->dateTime()),
			'selector'    => self::faker()->text(20),
			'user'        => UserFactory::new(),
		];
	}

	/**
	 * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
	 */
	protected function initialize (): static
	{
		return $this// ->afterInstantiate(function(ResetPasswordRequest $resetPasswordRequest): void {})
			;
	}
}
