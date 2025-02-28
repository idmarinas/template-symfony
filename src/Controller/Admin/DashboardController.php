<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 28/02/2025, 12:19
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

namespace App\Controller\Admin;

use App\Entity\Contact\Contact;
use App\Entity\User\User;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Override;
use Symfony\Component\Asset\Packages;
use Symfony\Component\HttpFoundation\Response;

#[AdminDashboard(routePath: '/%app.route_prefix.admin%', routeName: 'admin')]
final class DashboardController extends AbstractDashboardController
{
	public function __construct (private readonly Packages $package) {}

	public function index (): Response
	{
		return $this->render('admin/dashboard.html.twig');
	}

	public function configureDashboard (): Dashboard
	{
		$title = sprintf(
			'<img class="mx-auto d-block" src="%s" alt="" /><small>%s</small>',
			$this->package->getUrl('images/logos/icon96.webp'),
			$this->getParameter('app.title')
		);

		return parent::configureDashboard()
			->setTitle($title)
			->setFaviconPath('images/favicons/favicon.ico')
			->setLocales($this->getParameter('kernel.enabled_locales'))
			->setTranslationDomain('easyadmin')
		;
	}

	public function configureMenuItems (): iterable
	{
		yield MenuItem::linkToDashboard('dashboard.menu.dashboard', 'fa fa-home');

//		yield MenuItem::section('dashboard.menu.section.settings', 'fa-solid fa-gears');
//		yield MenuItem::linkToCrud('dashboard.menu.setting', 'fa-solid fa-gear', Setting::class);
//		yield MenuItem::linkToCrud('dashboard.menu.setting_domain', 'fa-solid fa-wrench', SettingDomain::class);

		yield MenuItem::section('dashboard.menu.section.users', 'fa fa-users');
		yield MenuItem::linkToCrud('dashboard.menu.user', 'fa fa-user', User::class);

		yield MenuItem::section('dashboard.menu.section.feedback', 'fa fa-comments');
		yield MenuItem::linkToCrud('dashboard.menu.contact', 'fa fa-message', Contact::class);
	}

	#[Override]
	public function configureActions (): Actions
	{
		return parent::configureActions()
			->add(Crud::PAGE_INDEX, Action::DETAIL)
			->add(Crud::PAGE_NEW, Action::INDEX)
			->update(Crud::PAGE_INDEX, Action::NEW, fn(Action $action) => $action->setIcon('fas fa-square-plus me-1'))
			->update(Crud::PAGE_INDEX, Action::EDIT, fn(Action $action) => $action->setIcon('fas fa-pen-to-square me-1'))
			->update(Crud::PAGE_INDEX, Action::DETAIL, fn(Action $action) => $action->setIcon('fas fa-eye me-1'))
			->update(
				Crud::PAGE_INDEX,
				Action::DELETE,
				fn(Action $action) => $action->setIcon('fas fa-trash-can text-danger me-1')
			)
			->setPermission('restore', 'ROLE_SUPER_ADMIN')
		;
	}
}
