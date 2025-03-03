<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 03/03/2025, 20:23
 *
 * @project IDMarinas Template Symfony
 * @see     https://github.com/idmarinas/template-symfony
 *
 * @file    UserCrudController.php
 * @date    20/02/2025
 * @time    15:51
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.0.0
 */

namespace Admin\Controller\User;

use Admin\Traits\Admin\Crud\CrudActionRestoreTrait;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use Idm\Bundle\User\Model\Controller\Admin\AbstractUserCrudController;
use Override;
use Shared\Entity\User\User;

final class UserCrudController extends AbstractUserCrudController
{
	use CrudActionRestoreTrait;

	public function __construct (private readonly EntityManagerInterface $entityManager) {}

	public static function getEntityFqcn (): string
	{
		return User::class;
	}

	#[Override]
	public function configureActions (Actions $actions): Actions
	{
		if ($this->entityManager->getFilters()->isEnabled('softdeleteable')) {
			$this->entityManager->getFilters()->disable('softdeleteable');
		}

		return parent::configureActions($this->restoreAction($actions));
	}
}
