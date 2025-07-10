<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 09/07/2025, 15:34
 *
 * @project IDMarinas Template Symfony
 * @see     https://github.com/idmarinas/template-symfony
 *
 * @file    SettingUser.php
 * @date    10/07/2025
 * @time    19:51
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.0.0
 */

namespace Core\Entity\Setting;

use Core\Entity\User\User;
use Core\Repository\Setting\SettingUserRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Idm\Bundle\Settings\EntityListener\SettingListener;
use Idm\Bundle\Settings\Interfaces\Entity\EntityWithSettingsInterface;
use Idm\Bundle\Settings\Interfaces\Entity\SettingsWithEntityInterface;
use Idm\Bundle\Settings\Interfaces\Entity\UseEncryptCacheInterface;
use Idm\Bundle\Settings\Model\Entity\AbstractSetting;

#[ORM\Table(name: 'idm_settings_setting_user')]
#[ORM\Entity(repositoryClass: SettingUserRepository::class)]
#[ORM\UniqueConstraint(name: 'idm_settings_uniq_idx_setting_user', columns: ['domain_id', 'name', 'entity_id'])]
#[ORM\EntityListeners([SettingListener::class])]
#[ORM\HasLifecycleCallbacks]
#[Gedmo\Loggable(logEntryClass: SettingUserLog::class)]
class SettingUser extends AbstractSetting implements SettingsWithEntityInterface, UseEncryptCacheInterface
{
	public const string ENTITY_NAME = 'user_settings';

	#[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'settings')]
	protected ?User $entity = null;

	public function getEntity (): ?User
	{
		return $this->entity;
	}

	public function setEntity (User|EntityWithSettingsInterface|null $entity): self
	{
		$this->entity = $entity;

		return $this;
	}
}
