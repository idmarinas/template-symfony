<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 02/03/2025, 18:39
 *
 * @project IDMarinas Template Symfony
 * @see     https://github.com/idmarinas/template-symfony
 *
 * @file    User.php
 * @date    20/02/2025
 * @time    15:51
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.0.0
 */

namespace Shared\Entity\User;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Idm\Bundle\User\Model\Entity\AbstractUser;
use Idm\Bundle\User\Traits\Entity\UserPremiumTrait;
use Shared\Repository\User\UserRepository;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: 'idm_user_user')]
#[Gedmo\Loggable(logEntryClass: UserLog::class)]
#[Gedmo\SoftDeleteable()]
#[UniqueEntity('email', message: 'idm_user_bundle.email.not_unique')]
#[UniqueEntity('displayName', message: 'idm_user_bundle.username.not_unique')]
class User extends AbstractUser
{
	use UserPremiumTrait;
	use SoftDeleteableEntity;

	public function __construct ()
	{
		$this->createdAt = new DateTime();
		$this->updatedAt = new DateTime();

		$this->premium = new Premium()
			->setUser($this)
		;
	}
}
