<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 03/03/2025, 22:02
 *
 * @project IDMarinas Template Symfony
 * @see     https://github.com/idmarinas/template-symfony
 *
 * @file    ContactControllerTest.php
 * @date    24/02/2025
 * @time    18:51
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.0.0
 */

namespace Web\Tests\Controller\Public;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Zenstruck\Foundry\Test\Factories;
use function Zenstruck\Foundry\faker;

class ContactControllerTest extends WebTestCase
{
	use Factories;

	public function testIndex ()
	{
		$client = static::createClient();
		$client->request(Request::METHOD_GET, '/public/contact/web');

		$this->assertResponseIsSuccessful();

		$this->assertPageTitleContains('IDMarinas Common Bundle');
		$this->assertSelectorTextContains('h2', 'Your information');
	}

	public function testSubmit ()
	{
		$client = static::createClient();
		$client->request(Request::METHOD_POST, '/public/contact/web');

		$client->submitForm('contact_form_buttonSubmit', [
			'contact_form[name]'     => faker()->firstName(),
			'contact_form[lastName]' => faker()->lastName(),
			'contact_form[email]'    => faker()->email(),
			'contact_form[comment]'  => faker()->text(),
			'contact_form[consent]'  => true,
		]);

		$this->assertResponseIsSuccessful();

		$this->assertSelectorTextContains('.flash-success', 'Your comments/questions have been sent successfully.');
	}

	public function testSubmitNotEmail ()
	{
		$client = static::createClient();
		$client->request(Request::METHOD_POST, '/public/contact/web');

		$client->submitForm('contact_form_buttonSubmit', [
			'contact_form[name]'     => faker()->firstName(),
			'contact_form[lastName]' => faker()->lastName(),
			'contact_form[comment]'  => faker()->text(),
			'contact_form[consent]'  => true,
		]);

		$this->assertResponseIsSuccessful();

		$this->assertSelectorTextContains('.flash-success', 'Your comments/questions have been sent successfully.');
	}

	public function testSubmitInvalid ()
	{
		$client = static::createClient();
		$client->request(Request::METHOD_POST, '/public/contact/web');

		$client->submitForm('contact_form_buttonSubmit', [
			'contact_form[name]'     => faker()->name(),
			'contact_form[lastName]' => faker()->lastName(),
			'contact_form[comment]'  => faker()->text(400),
			'contact_form[consent]'  => false,
		]);

		$this->assertResponseIsUnprocessable();

		$this->assertSelectorTextContains('form', 'This value should be true.');
	}
}
