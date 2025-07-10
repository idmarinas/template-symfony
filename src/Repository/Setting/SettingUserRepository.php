<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 10/07/2025, 19:52
 *
 * @project IDMarinas Template Symfony
 * @see     https://github.com/idmarinas/template-symfony
 *
 * @file    SettingUserRepository.php
 * @date    10/07/2025
 * @time    19:52
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.0.0
 */

namespace Core\Repository\Setting;

use Core\Entity\Setting\SettingUser;
use Doctrine\Persistence\ManagerRegistry;
use Idm\Bundle\Settings\Model\Repository\AbstractSettingRepository;

final class SettingUserRepository extends AbstractSettingRepository
{
	public function __construct (ManagerRegistry $registry)
	{
		parent::__construct($registry, SettingUser::class);
	}
}
