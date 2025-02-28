<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 28/02/2025, 12:21
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

namespace App\Controller\Admin\Feedback;

use App\Entity\Contact\Contact;
use App\Traits\Admin\Crud\CrudActionRestoreTrait;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use Idm\Bundle\Common\Model\Controller\Admin\AbstractContactCrudController;
use Override;
use function Symfony\Component\Translation\t;

class ContactCrudController extends AbstractContactCrudController
{
	use CrudActionRestoreTrait;

	public function __construct (private readonly EntityManagerInterface $entityManager) {}

	public static function getEntityFqcn (): string
	{
		return Contact::class;
	}

	public function configureFields (string $pageName): iterable
	{
		$t = fn($message) => t($message, [], 'IdmUserBundle');
		yield from parent::configureFields($pageName);

		yield BooleanField::new('isDeleted', $t('crud.common.is_deleted'))
			->hideOnForm()
			->renderAsSwitch(false)
			->setVirtual(true)
		;
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
