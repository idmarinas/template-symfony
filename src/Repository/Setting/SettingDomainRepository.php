<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 10/07/2025, 19:51
 *
 * @project IDMarinas Template Symfony
 * @see     https://github.com/idmarinas/template-symfony
 *
 * @file    SettingDomainRepository.php
 * @date    10/07/2025
 * @time    19:52
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.0.0
 */

namespace Core\Repository\Setting;

use Core\Entity\Setting\SettingDomain;
use Doctrine\Persistence\ManagerRegistry;
use Idm\Bundle\Settings\Model\Repository\AbstractSettingDomainRepository;

final class SettingDomainRepository extends AbstractSettingDomainRepository
{
	public function __construct (ManagerRegistry $registry)
	{
		parent::__construct($registry, SettingDomain::class);
	}
}
