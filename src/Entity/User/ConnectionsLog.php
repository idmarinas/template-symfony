<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 20/02/2025, 15:51
 *
 * @project IDMarinas Template Symfony
 * @see     https://github.com/idmarinas/template-symfony
 *
 * @file    ConnectionsLog.php
 * @date    20/02/2025
 * @time    15:51
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.0.0
 */

namespace App\Entity\User;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Loggable\Entity\MappedSuperclass\AbstractLogEntry;
use Gedmo\Loggable\Entity\Repository\LogEntryRepository;

#[ORM\Entity(repositoryClass: LogEntryRepository::class)]
#[ORM\Table(name: 'idm_user_connections_log', options: ['row_format' => 'DYNAMIC'])]
#[ORM\Index(name: 'idm_user_connections_log_class_lookup_idx', columns: ['object_class'])]
#[ORM\Index(name: 'idm_user_connections_log_date_lookup_idx', columns: ['logged_at'])]
#[ORM\Index(name: 'idm_user_connections_log_user_lookup_idx', columns: ['username'])]
#[ORM\Index(name: 'idm_user_connections_log_version_lookup_idx', columns: ['object_id', 'object_class', 'version'])]
class ConnectionsLog extends AbstractLogEntry
{
	/* All required columns are mapped through inherited superclass */
}
