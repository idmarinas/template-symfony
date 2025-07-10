<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 10/07/2025, 19:50
 *
 * @project IDMarinas Template Symfony
 * @see     https://github.com/idmarinas/template-symfony
 *
 * @file    SettingLog.php
 * @date    10/07/2025
 * @time    19:51
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.0.0
 */

namespace Core\Entity\Setting;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Loggable\Entity\MappedSuperclass\AbstractLogEntry;
use Gedmo\Loggable\Entity\Repository\LogEntryRepository;

#[ORM\Entity(repositoryClass: LogEntryRepository::class)]
#[ORM\Table(name: 'idm_settings_sttg_log', options: ['row_format' => 'DYNAMIC'])]
#[ORM\Index(name: 'idm_settings_sttg_log_class_lookup_idx', columns: ['object_class'])]
#[ORM\Index(name: 'idm_settings_sttg_log_date_lookup_idx', columns: ['logged_at'])]
#[ORM\Index(name: 'idm_settings_sttg_log_user_lookup_idx', columns: ['username'])]
#[ORM\Index(name: 'idm_settings_sttg_log_version_lookup_idx', columns: ['object_id', 'object_class', 'version'])]
class SettingLog extends AbstractLogEntry
{
	/* All required columns are mapped through inherited superclass */
}
