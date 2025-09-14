<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 14/09/2025, 11:32
 *
 * @project IDMarinas Template Symfony
 * @see     https://github.com/idmarinas/template-symfony
 *
 * @file    maintenance.php
 * @date    10/09/2025
 * @time    11:56
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.0.0
 */

namespace Deployer;

use DateInterval;
use DateTimeImmutable;
use DateTimeZone;

import('recipe/common.php');

desc('Activa el modo mantenimiento');
task('maintenance:on', function () {
    $duration = get('doctrine_migrations_estimated_duration');

    // fecha de inicio en formato ISO8601
    $start = new DateTimeImmutable('now', new DateTimeZone('UTC'));

    // calcular fecha de fin según duración
    if (preg_match('/^(\d+)([mh])$/', $duration, $matches)) {
        $value = (int)$matches[1];
        $unit = strtoupper($matches[2]);
    } else {
        $value = 30;
        $unit = 'M';
    }

    $end = $start->add(new DateInterval("PT{$value}{$unit}"));

    // JSON con datos
    $json = json_encode([
        'start'    => $start->format('c'),
        'duration' => $duration,
        'end'      => $end->format('c'),
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

    run("{{bin/webserver}} sh -c 'cat > /app/maintenance.flag <<'\\''EOF'\\''\n$json\nEOF'");

    writeln('<info>Modo mantenimiento activado hasta: <options=bold>' . $end->format('Y-m-d H:i:s T') . '</></>');
});

desc('Desactivar modo mantenimiento');
task('maintenance:off', function () {
    writeln('<info>Desactivando modo mantenimiento...</>');
    run('{{bin/webserver}} rm -f /app/maintenance.flag');
});
