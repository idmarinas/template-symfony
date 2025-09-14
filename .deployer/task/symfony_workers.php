<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 14/09/2025, 11:32
 *
 * @project IDMarinas Template Symfony
 * @see     https://github.com/idmarinas/template-symfony
 *
 * @file    symfony_workers.php
 * @date    07/05/2025
 * @time    22:07
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.0.0
 */

namespace Deployer;

import('recipe/common.php');

set('msn_workers_container_names', [
    'Messenger Worker Async'     => 'pfc-messenger_worker_async-1',
    'Messenger Worker Scheduler' => 'pfc-messenger_worker_scheduler-1',
]);

//
// Tasks
//

desc();
task('deploy:symfony:workers:stop', function () {
    writeln('<info>Deteniendo y borrando los contenedores workers</>');

    $workers = get('msn_workers_container_names');

    foreach ($workers as $name => $worker) {
        if (test('[ -n "$(docker ps -q --filter name=' . $worker . ')" ]')) {
            writeln("<info>Deteniendo worker y Borrando contenedor: <options=bold>$name</></info>");
            run("docker exec $worker php bin/console messenger:stop-workers");
            run("docker wait $worker");
            run("docker rm -f $worker");
        } elseif (test('[ -n "$(docker ps -aq --filter name=' . $worker . ')" ]')) {
            writeln("<fg=yellow>El worker <options=bold>$name</> no está funcionando se borra el contenedor.</>");
            run("docker rm -f $worker");
        } else {
            writeln("<fg=red>El worker <options=bold>$name</> no tiene un contenedor asociado.</>");
        }
    }
});
