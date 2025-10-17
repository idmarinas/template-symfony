#!/bin/sh



##
# Copyright 2025 (C) IDMarinas - All Rights Reserved
#
# Last modified by "IDMarinas" on 17/10/2025, 18:37
#
# @project IDMarinas Template Symfony
# @see https://github.com/idmarinas/template-symfony
#
# @file worker_scheduler.sh
# @date 17/10/2025
# @time 18:41
#
# @author Iván Diaz Marinas (IDMarinas)
# @license BSD 3-Clause License
#
# @since 1.0.0
#

# Scheduler parece que no es compatible con la opción --limit
docker-php-entrypoint
php bin/console messenger:consume scheduler_default --time-limit=3600 --memory-limit=128M
