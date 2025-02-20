<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 20/02/2025, 15:51
 *
 * @project IDMarinas Template Symfony
 * @see     https://github.com/idmarinas/template-symfony
 *
 * @file    ResetPasswordRequest.php
 * @date    20/02/2025
 * @time    15:51
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.0.0
 */

namespace App\Entity\User;

use App\Repository\User\ResetPasswordRequestRepository;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Idm\Bundle\Common\Traits\Entity\UuidTrait;
use SymfonyCasts\Bundle\ResetPassword\Model\ResetPasswordRequestInterface;
use SymfonyCasts\Bundle\ResetPassword\Model\ResetPasswordRequestTrait;

#[ORM\Entity(repositoryClass: ResetPasswordRequestRepository::class)]
#[ORM\Table(name: 'idm_user_reset_password_request')]
#[Gedmo\Loggable(logEntryClass: ResetPasswordRequestLog::class)]
class ResetPasswordRequest implements ResetPasswordRequestInterface
{
	use ResetPasswordRequestTrait;
	use UuidTrait;

	#[ORM\ManyToOne]
	#[ORM\JoinColumn(nullable: false)]
	private(set) ?User $user {
		get {
			return $this->user;
		}
	}

	public function __construct (
		User              $user,
		DateTimeInterface $expiresAt,
		string            $selector,
		string            $hashedToken
	) {
		$this->user = $user;
		$this->initialize($expiresAt, $selector, $hashedToken);
	}
}
