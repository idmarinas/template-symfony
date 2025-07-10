<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 09/07/2025, 15:34
 *
 * @project IDMarinas Template Symfony
 * @see     https://github.com/idmarinas/template-symfony
 *
 * @file    SettingDomain.php
 * @date    10/07/2025
 * @time    19:51
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.0.0
 */

namespace Core\Entity\Setting;

use Core\Repository\Setting\SettingDomainRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Idm\Bundle\Settings\EntityListener\SettingDomainListener;
use Idm\Bundle\Settings\Model\Entity\AbstractSettingDomain;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/** Domain for settings of Symfony App */
#[ORM\Table(name: 'idm_settings_setting_domain')]
#[ORM\Entity(repositoryClass: SettingDomainRepository::class)]
#[UniqueEntity(fields: 'name', message: 'domain.not_unique')]
#[ORM\EntityListeners([SettingDomainListener::class])]
#[Gedmo\Loggable(logEntryClass: SettingDomainLog::class)]
class SettingDomain extends AbstractSettingDomain {}
