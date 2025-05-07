<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 05/03/2025, 11:47
 *
 * @project IDMarinas Template Symfony
 * @see     https://github.com/idmarinas/template-symfony
 *
 * @file    var_texts_common.php
 * @date    07/05/2025
 * @time    22:07
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.0.0
 */

/** @noinspection PhpUnhandledExceptionInspection */

namespace Deployer;

import('recipe/common.php');

set('local_prod_text', '<fg=magenta;options=bold>PROD</>');
set('local_dev_text', '<fg=red;options=bold>DEV</>');
