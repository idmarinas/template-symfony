<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 20/02/2025, 18:13
 *
 * @project IDMarinas Template Symfony
 * @see     https://github.com/idmarinas/template-symfony
 *
 * @file    ContactCrudController.php
 * @date    20/02/2025
 * @time    18:13
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.0.0
 */

namespace App\Controller\Admin\Contact;

use App\Entity\Contact\Contact;
use Idm\Bundle\Common\Model\Controller\Admin\AbstractContactCrudController;

class ContactCrudController extends AbstractContactCrudController
{
	public static function getEntityFqcn (): string
	{
		return Contact::class;
	}
}
