<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 25/02/2025, 20:17
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

use App\Entity\User\User;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
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
	}

	public function configureActions (): Actions
	{
		return parent::configureActions()
			->add(Crud::PAGE_INDEX, Action::DETAIL)
		;
	}
}
