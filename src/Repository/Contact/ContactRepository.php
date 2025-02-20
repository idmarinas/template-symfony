<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 20/02/2025, 18:10
 *
 * @project IDMarinas Template Symfony
 * @see     https://github.com/idmarinas/template-symfony
 *
 * @file    ContactRepository.php
 * @date    20/02/2025
 * @time    18:09
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.0.0
 */

namespace App\Repository\Contact;

use App\Entity\Contact\Contact;
use Doctrine\Persistence\ManagerRegistry;
use Idm\Bundle\Common\Model\Repository\AbstractContactRepository;

class ContactRepository extends AbstractContactRepository
{
	public function __construct (ManagerRegistry $registry)
	{
		parent::__construct($registry, Contact::class);
	}
}
