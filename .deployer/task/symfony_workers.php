<?php

namespace Deployer;

set('symfony/workers/names', [
	'Messenger Worker Async'     => 'worker_async',
	'Messenger Worker Scheduler' => 'worker_scheduler',
]);

//
// Tasks
//
desc('Detener y borrar los contenedores workers para recrearlos');
task('deploy:symfony:workers:stop', function () {
	writeln('<info>Deteniendo y borrando los contenedores workers</>');

	$workers = parseServicesToContainers(get('symfony/workers/names'));

	foreach ($workers as $name => $worker) {
		if (test('[ -n "$(docker ps -q --filter name='.$worker.')" ]')) {
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
		} elseif (test('[ -n "$(docker ps -aq --filter name='.$worker.')" ]')) {
			writeln("<fg=yellow>El worker <options=bold>$name</> no está funcionando se borra el contenedor.</>");
			run("docker rm -f $worker");
		} else {
			writeln("<fg=red>El worker <options=bold>$name</> no tiene un contenedor asociado.</>");
		}
	}
});

desc('Iniciar contenedores workers');
task('deploy:symfony:workers:start', function () {
	info('Creando contenedores workers en "{{text_prod}}"');
	within('{{release_or_current_path}}', function () {
		$workers = implode(' ', get('symfony/workers/names'));
		run('docker compose {{docker/compose/files}} up -d --wait '.$workers);
	});
});
