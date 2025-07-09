<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 09/07/2025, 18:02
 *
 * @project IDMarinas Template Symfony
 * @see     https://github.com/idmarinas/template-symfony
 *
 * @file    Connections.php
 * @date    20/02/2025
 * @time    15:51
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license undefined
 *
 * @since   1.0.0
 */

namespace Core\Entity\User;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Idm\Bundle\User\Model\Entity\AbstractConnections;

#[ORM\Entity]
#[ORM\Table(name: 'idm_user_connections')]
#[Gedmo\Loggable(logEntryClass: ConnectionsLog::class)]
class Connections extends AbstractConnections {}
