<?php

namespace Deployer;

set('symfony/workers/names', [
	'Messenger Worker Async'     => '{{docker/project_name}}-worker_async-1',
	'Messenger Worker Scheduler' => '{{docker/project_name}}-worker_scheduler-1',
]);

//
// Tasks
//
desc('Detener y borrar los contenedores workers para recrearlos');
task('deploy:symfony:workers:stop', function () {
	writeln('<info>Deteniendo y borrando los contenedores workers</>');

	$workers = get('symfony/workers/names');

	foreach ($workers as $name => $worker) {
		if (test('[ -n "$(docker ps -q --filter name=' . $worker . ')" ]')) {
			info("Deteniendo worker y Borrando contenedor: <options=bold>$name</>");

			// Comprobar el estado del worker
			$status = run("docker inspect $worker");
			$status = json_decode($status, true)[0]['State']['Status'];

			if ('running' == $status) {
				run("docker exec $worker php bin/console messenger:stop-workers");
				run("docker wait $worker");
				run("docker rm -f $worker");
			} else {
				// El contenedor probablemente esté reiniciando
				run("docker stop $worker");
				run("docker rm -f $worker");
			}
		} elseif (test('[ -n "$(docker ps -aq --filter name=' . $worker . ')" ]')) {
			writeln("<fg=yellow>El worker <options=bold>$name</> no está funcionando se borra el contenedor.</>");
			run("docker rm -f $worker");
		} else {
			writeln("<fg=red>El worker <options=bold>$name</> no tiene un contenedor asociado.</>");
		}
	}
});
