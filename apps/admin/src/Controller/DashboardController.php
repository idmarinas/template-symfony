<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 19/10/2025, 18:11
 *
 * @project IDMarinas Template Symfony
 * @see     https://github.com/idmarinas/template-symfony
 *
 * @file    DashboardController.php
 * @date    20/02/2025
 * @time    18:17
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.0.0
 */

namespace Admin\Controller;

use Admin\Enums\Crud\ActionsEnum;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Override;
use Symfony\Component\Asset\Packages;
use Symfony\Component\HttpFoundation\Response;

#[AdminDashboard(
	routePath   : '/%app.route_prefix.admin%',
	routeName   : 'admin',
	routeOptions: ['methods' => 'GET'],
	routes      : ['index' => ['routePath' => '/all']])]
final class DashboardController extends AbstractDashboardController
{
	public function __construct (
		private readonly Packages $packages,
	) {}

	#[Override]
	public function index (): Response
	{
		return $this->render('@Admin/dashboard.html.twig');
	}

	#[Override]
	public function configureDashboard (): Dashboard
	{
		$title = sprintf(
			'<img class="mx-auto d-block" src="%s" alt="" /><small>%s</small>',
			$this->packages->getUrl('images/logos/icon96.webp'),
			$this->getParameter('app.title')
		);

		return parent::configureDashboard()
			->setTitle($title)
			->setFaviconPath('images/favicons/favicon.ico')
			->setLocales($this->getParameter('kernel.enabled_locales'))
			->setTranslationDomain('easyadmin')
		;
	}

	#[Override]
	public function configureMenuItems (): iterable
	{
		yield from parent::configureMenuItems();
	}

	#[Override]
	public function configureActions (): Actions
	{
		$detail = fn(Action $action) => $action->setIcon('fas fa-eye');
		$edit = fn(Action $action) => $action->setIcon('fas fa-pen-to-square');
		$delete = fn(Action $action) => $action->setIcon('fas fa-trash-can text-danger');
		$save = fn(Action $action) => $action->setIcon('fa-solid fa-floppy-disk');
		$new = fn(Action $action) => $action->setIcon('fas fa-square-plus me-1');

		return parent::configureActions()
			->add(Crud::PAGE_INDEX, Action::DETAIL)
			->add(Crud::PAGE_NEW, Action::INDEX)
			->add(Crud::PAGE_EDIT, Action::DETAIL)
			->add(Crud::PAGE_EDIT, Action::DELETE)
			->update(Crud::PAGE_INDEX, Action::NEW, $new)
			->update(Crud::PAGE_INDEX, Action::EDIT, $edit)
			->update(Crud::PAGE_INDEX, Action::DETAIL, $detail)
			->update(Crud::PAGE_INDEX, Action::DELETE, $delete)
			->update(Crud::PAGE_EDIT, Action::DETAIL, $detail)
			->update(Crud::PAGE_EDIT, Action::SAVE_AND_RETURN, $save)
			->update(Crud::PAGE_DETAIL, Action::EDIT, $edit)
			->setPermission(ActionsEnum::RESTORE, 'ROLE_SUPER_ADMIN')
			->setPermission('log-entry', 'ROLE_SUPER_ADMIN')
		;
	}
}
