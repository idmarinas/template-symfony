<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 09/07/2025, 15:34
 *
 * @project IDMarinas Template Symfony
 * @see     https://github.com/idmarinas/template-symfony
 *
 * @file    Setting.php
 * @date    10/07/2025
 * @time    19:51
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.0.0
 */

namespace Core\Entity\Setting;

use Core\Repository\Setting\SettingRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Idm\Bundle\Settings\EntityListener\SettingListener;
use Idm\Bundle\Settings\Model\Entity\AbstractSetting;

#[ORM\Table(name: 'idm_settings_setting')]
#[ORM\UniqueConstraint(name: 'idm_settings_uniq_idx__setting', columns: ['domain_id', 'name'])]
#[ORM\Entity(repositoryClass: SettingRepository::class)]
#[ORM\EntityListeners([SettingListener::class])]
#[ORM\HasLifecycleCallbacks]
#[Gedmo\Loggable(logEntryClass: SettingLog::class)]
class Setting extends AbstractSetting
{
	public const string ENTITY_NAME = 'setting';
}
