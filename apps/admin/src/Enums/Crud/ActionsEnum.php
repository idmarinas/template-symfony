<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 17/07/2025, 19:41
 *
 * @project IDMarinas Template Symfony
 * @see     https://github.com/idmarinas/template-symfony
 *
 * @file    ActionsEnum.php
 * @date    11/07/2025
 * @time    18:34
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.0.0
 */

namespace Admin\Enums\Crud;

enum ActionsEnum
{
	const string RESTORE          = 'restore';
	const string LOG_INDEX        = 'logEntryIndex';
	const string LOG_OBJECT_INDEX = 'logEntryObjectIndex';
}
