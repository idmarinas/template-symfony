<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 27/02/2025, 20:09
 *
 * @project IDMarinas Template Symfony
 * @see     https://github.com/idmarinas/template-symfony
 *
 * @file    RedirectToCrudIndexTrait.php
 * @date    27/02/2025
 * @time    20:02
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.0.0
 */

namespace App\Traits\Admin\Crud;

use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Option\EA;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

trait RedirectToCrudIndexTrait
{
	/**
	 * @throws ContainerExceptionInterface
	 * @throws NotFoundExceptionInterface
	 */
	private function redirectToCrudIndex (AdminContext $context): string
	{
		$generator = $this->container
			->get(AdminUrlGenerator::class)
			->setController($context->getCrud()->getControllerFqcn())
			->setAction(Action::INDEX)
			->unset(EA::ENTITY_ID)
		;

		return $generator->generateUrl();
	}
}
