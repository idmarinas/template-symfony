<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 28/02/2025, 12:17
 *
 * @project IDMarinas Template Symfony
 * @see     https://github.com/idmarinas/template-symfony
 *
 * @file    CrudActionRestoreTrait.php
 * @date    27/02/2025
 * @time    20:02
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.0.0
 */

namespace App\Traits\Admin\Crud;

use App\Entity\User\User;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminAction;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeCrudActionEvent;
use EasyCorp\Bundle\EasyAdminBundle\Exception\ForbiddenActionException;
use EasyCorp\Bundle\EasyAdminBundle\Exception\InsufficientEntityPermissionException;
use EasyCorp\Bundle\EasyAdminBundle\Security\Permission;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

trait CrudActionRestoreTrait
{
	use RedirectToCrudIndexTrait;

	/**
	 * Restore a deleted object
	 */
	#[AdminAction(routePath: '/{entityId}/restore', routeName: 'restore', methods: ['GET'])]
	public function restore (AdminContext $context): RedirectResponse|Response
	{
		$event = new BeforeCrudActionEvent($context);
		$this->container->get('event_dispatcher')->dispatch($event);
		if ($event->isPropagationStopped()) {
			return $event->getResponse();
		}

		if (!$this->isGranted(
			Permission::EA_EXECUTE_ACTION,
			['action' => 'restore', 'entity' => $context->getEntity(), 'entityFqcn' => $context->getEntity()->getFqcn()]
		)) {
			throw new ForbiddenActionException($context);
		}

		if (!$context->getEntity()->isAccessible()) {
			throw new InsufficientEntityPermissionException($context);
		}

		/**
		 * @var $object User
		 */
		$object = $context->getEntity()->getInstance();
		$object->setDeletedAt();
		$this->entityManager->persist($object);
		$this->entityManager->flush();

		return $this->redirect($this->redirectToCrudIndex($context));
	}

	protected function restoreAction (Actions $actions): Actions
	{
		// restore action, it will be displayed in light blue with a FontAwesome restore icon
		$restore = Action::new('restore', 'action.restore', 'fas fa-trash-restore-alt me-1 text-info')
			->linkToCrudAction('restore')
			->addCssClass('text-info')
			->displayIf(static function (object $object) {
				return (method_exists($object, 'isDeleted')) ? $object->isDeleted() : false;
			})
		;

		return $actions
			->add(Crud::PAGE_INDEX, $restore)
			->reorder(Crud::PAGE_INDEX, [Action::DETAIL, Action::EDIT, 'restore', Action::DELETE])
			->setPermission('restore', 'ROLE_SUPER_ADMIN')
		;
	}
}
