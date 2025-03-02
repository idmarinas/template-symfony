<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 02/03/2025, 18:39
 *
 * @project IDMarinas Template Symfony
 * @see     https://github.com/idmarinas/template-symfony
 *
 * @file    Contact.php
 * @date    20/02/2025
 * @time    18:09
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.0.0
 */

namespace Shared\Entity\Contact;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Idm\Bundle\Common\Model\Entity\AbstractContact;
use Shared\Repository\Contact\ContactRepository;

#[ORM\Table(name: 'idm_common_contact')]
#[ORM\Index(name: 'email_idx', columns: ['email'])]
#[ORM\Entity(repositoryClass: ContactRepository::class)]
#[Gedmo\Loggable(logEntryClass: ContactLog::class)]
#[Gedmo\SoftDeleteable()]
class Contact extends AbstractContact
{
	use SoftDeleteableEntity;

	public function __construct ()
	{
		$this->createdAt = new DateTime();
		$this->updatedAt = new DateTime();
	}
}
