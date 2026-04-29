<?php

namespace Deployer;

set('docker/services/start', 'webserver database');
set('docker/compose/files', '--env-file .env.docker -f compose.yaml -f compose.prod.yaml');
set('docker/registry', 'ghcr.io');
set('docker/image/name', '{{docker/registry}}/{{github/repository}}:{{app/version}}-build.{{app/version/build}}');

//
// Tasks
//
desc('Construir la imagen Docker (PROD) y subirla a GHCR');
task('docker:image:build', function () {
	writeln('<info>Construyendo imagen Docker</>');
	runLocally('docker build --target prod -f .docker/Dockerfile -t {{docker/image/name}} .', timeout: null);

	writeln('<info>Autenticándose en {{docker/registry}} localmente</>');
	$ghcr_pat = file_get_contents(dirname(__DIR__, 2).'/.GHCR_PAT');
	if (empty($ghcr_pat)) {
		throw error(
			'La variable de entorno GHCR_PAT no está definida. Se requiere un GitHub Personal Access Token con acceso a ghcr.io'
		);
	}
	runLocally("echo '$ghcr_pat' | docker login {{docker/registry}} -u {{github/user}} --password-stdin");

	writeln('<info>Subiendo imagen a {{docker/registry}}</>');
	runLocally('docker push {{docker/image/name}}', timeout: null);
});

desc('Autenticarse en GHCR en el servidor');
task('docker:registry:login', function () {
	writeln('<info>Autenticándose en {{docker/registry}} en {{text_prod}}</>');
	$pat = run('echo $GHCR_PAT');

	if (empty(trim($pat))) {
		throw error('La variable de entorno GHCR_PAT no está definida en el servidor.');
	}

	run("echo $pat | docker login {{docker/registry}} -u {{github/user}} --password-stdin");
});

desc('Descargar imagen Docker desde GHCR en el servidor');
task('docker:image:pull', function () {
	writeln('<info>Descargando imagen {{docker/image/name}} en {{text_prod}}</>');
	run('docker pull {{docker/image/name}}', timeout: null);
});

desc('Copiar archivo .env.docker de la imagen Docker');
task('docker:copy:env_docker', function () {
	writeln('<info>Copiando archivo .env.docker</>');
	run('docker create --name deployer_{{docker/project_name}}_temp {{docker/image/name}}');
	run('docker cp deployer_{{docker/project_name}}_temp:/app/.env.docker {{release_path}}/.env.docker');
	run('docker rm deployer_{{docker/project_name}}_temp');
});

desc('Iniciar de los servicios Docker');
task('docker:service:start', function () {
	writeln('<info>Creando contenedor Docker en "{{text_prod}}"</>');
	within('{{release_or_current_path}}', function () {
		run('docker compose {{docker/compose/files}} up -d --wait {{docker/services/start}}');
	});
})
	->addAfter('docker:volume:restore')
	->hidden()
;

desc('Eliminar imágenes Docker no utilizadas');
task('docker:image:prune', function () {
	$output = run('docker image prune -f');
	$lines = explode("\n", trim($output));

	writeln('<info>'.end($lines).'</>');
});

before('deploy:cleanup', 'docker:image:prune');
