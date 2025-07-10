<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 10/07/2025, 19:41
 *
 * @project IDMarinas Template Symfony
 * @see     https://github.com/idmarinas/template-symfony
 *
 * @file    User.php
 * @date    20/02/2025
 * @time    15:51
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.0.0
 */

namespace Core\Entity\User;

use Core\Entity\Setting\SettingUser;
use Core\Repository\User\UserRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Idm\Bundle\Settings\Interfaces\Entity\EntityWithSettingsInterface;
use Idm\Bundle\Settings\Model\Entity\AbstractSetting;
use Idm\Bundle\User\Model\Entity\AbstractUser;
use Idm\Bundle\User\Traits\Entity\UserPremiumTrait;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: 'idm_user_user')]
#[Gedmo\Loggable(logEntryClass: UserLog::class)]
#[Gedmo\SoftDeleteable]
#[UniqueEntity('email', message: 'idm_user_bundle.email.not_unique')]
#[UniqueEntity('displayName', message: 'idm_user_bundle.username.not_unique')]
class User extends AbstractUser implements EntityWithSettingsInterface
{
	use UserPremiumTrait;
	use SoftDeleteableEntity;

	/** @var Collection<int, AbstractSetting> */
	#[ORM\OneToMany(targetEntity: SettingUser::class, mappedBy: 'entity', cascade: ['all'])]
	public Collection $settings {
		get => $this->settings;
	}

	public function __construct ()
	{
		$this->createdAt = new DateTime();
		$this->updatedAt = new DateTime();
		$this->premium = new Premium()->setUser($this);
		$this->settings = new ArrayCollection();
	}

	public function addSetting (SettingUser|AbstractSetting $setting): self
	{
		if (!$this->settings->contains($setting)) {
			$setting->setEntity($this);

			$this->settings->add($setting);
		}

		return $this;
	}

	public function removeSetting (SettingUser|AbstractSetting $setting): self
	{
		if ($this->settings->removeElement($setting) && $setting->getEntity() === $this) {
			// set the owning side to null (unless already changed)
			$setting->setEntity(null);
		}

		return $this;
	}
}
