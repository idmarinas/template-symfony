#!/bin/sh

##
# Copyright 2025 (C) IDMarinas - All Rights Reserved
#
# Last modified by "IDMarinas" on 17/10/2025, 18:38
#
# @project IDMarinas Template Symfony
# @see https://github.com/idmarinas/template-symfony
#
# @file dev_entrypoint.sh
# @date 09/09/2025
# @time 10:28
#
# @author Iván Diaz Marinas (IDMarinas)
# @license BSD 3-Clause License
#
# @since 1.0.0
#

dockerd &
docker-php-entrypoint
exec frankenphp run --config '/etc/frankenphp/Caddyfile' "$@"
