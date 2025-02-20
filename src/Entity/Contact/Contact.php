<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 20/02/2025, 18:09
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

namespace App\Entity\Contact;

use App\Repository\Contact\ContactRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Idm\Bundle\Common\Model\Entity\AbstractContact;

#[ORM\Table(name: 'idm_common_contact')]
#[ORM\Entity(repositoryClass: ContactRepository::class)]
#[Gedmo\Loggable(logEntryClass: ContactLog::class)]
class Contact extends AbstractContact {}
