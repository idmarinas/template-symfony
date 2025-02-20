<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 20/02/2025, 18:09
 *
 * @project IDMarinas Template Symfony
 * @see     https://github.com/idmarinas/template-symfony
 *
 * @file    ContactFormType.php
 * @date    20/02/2025
 * @time    18:08
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.0.0
 */

namespace App\Form\Contact;

use App\Entity\Contact\Contact;
use Idm\Bundle\Common\Model\Form\AbstractContactFormType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactFormType extends AbstractContactFormType
{
	public function configureOptions (OptionsResolver $resolver): void
	{
		parent::configureOptions($resolver);

		$resolver->setDefaults([
			'data_class' => Contact::class,
		]);
	}
}
