<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 27/02/2025, 18:02
 *
 * @project IDMarinas Template Symfony
 * @see     https://github.com/idmarinas/template-symfony
 *
 * @file    ResetPasswordRequestRepository.php
 * @date    20/02/2025
 * @time    15:51
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.0.0
 */

namespace App\Repository\User;

use App\Entity\User\ResetPasswordRequest;
use Doctrine\Persistence\ManagerRegistry;
use Idm\Bundle\User\Model\Repository\AbstractResetPasswordRequestRepository;

class ResetPasswordRequestRepository extends AbstractResetPasswordRequestRepository
{
	public function __construct (ManagerRegistry $registry)
	{
		parent::__construct($registry, ResetPasswordRequest::class);
	}
}
