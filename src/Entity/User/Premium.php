<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 20/02/2025, 15:51
 *
 * @project IDMarinas Template Symfony
 * @see     https://github.com/idmarinas/template-symfony
 *
 * @file    Premium.php
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
use Gedmo\Mapping\Annotation as Gedmo;
use Idm\Bundle\User\Model\Entity\AbstractPremium;

#[ORM\Entity]
#[ORM\Table(name: 'idm_user_premium')]
#[Gedmo\Loggable(logEntryClass: PremiumLog::class)]
class Premium extends AbstractPremium {}
