<?php

/**
 * Copyright 2024-2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 22/11/2024, 17:10
 *
 * @project IDMarinas Template Symfony
 * @see     https://github.com/idmarinas/template-symfony
 *
 * @file    create_env_file.php
 * @date    20/02/2025
 * @time    17:34
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.0.0
 */

// Incluye el archivo de configuración
$dir = dirname(__DIR__, 2);
$config = include "$dir/.env.local.php";

// Abre (o crea) el archivo .env para escribir
$envFile = fopen("$dir/.env.docker", 'w');

// Recorre el array y escribe cada clave-valor en el archivo .env
foreach ($config as $key => $value) {
	if (str_contains($value, ' ')) {
		$value = '"' . $value . '"';
	}

	fwrite($envFile, "$key=$value\n");
}

// Cierra el archivo
fclose($envFile);

echo '.env.docker file has been created successfully.';
