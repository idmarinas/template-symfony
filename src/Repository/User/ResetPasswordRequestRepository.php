<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 10/07/2025, 19:17
 *
 * @project IDMarinas Template Symfony
 * @see     https://github.com/idmarinas/template-symfony
 *
 * @file    ResetPasswordRequestRepository.php
 * @date    20/02/2025
 * @time    15:51
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license undefined
 *
 * @since   1.0.0
 */

namespace Core\Repository\User;

use Core\Entity\User\ResetPasswordRequest;
use Doctrine\Persistence\ManagerRegistry;
use Idm\Bundle\User\Model\Repository\AbstractResetPasswordRequestRepository;

final class ResetPasswordRequestRepository extends AbstractResetPasswordRequestRepository
{
	public function __construct (ManagerRegistry $registry)
	{
		parent::__construct($registry, ResetPasswordRequest::class);
	}
}
