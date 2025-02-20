<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 20/02/2025, 15:55
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

namespace App\Entity\User;

use App\Repository\User\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Idm\Bundle\User\Model\Entity\AbstractUser;
use Idm\Bundle\User\Traits\Entity\UserPremiumTrait;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: 'idm_user_user')]
#[Gedmo\Loggable(logEntryClass: UserLog::class)]
class User extends AbstractUser
{
	use UserPremiumTrait;

	public function __construct ()
	{
		$this->premium = (new Premium())
			->setUser($this)
		;
	}
}
