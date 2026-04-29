<?php

namespace Deployer;

use Throwable;

set('need_db_migration', false);
set('doctrine_schema_validate_config', '--skip-mapping');
set('doctrine/migration/duration', '1m');
set('migrations/options', '--no-interaction --allow-no-migration');

//desc('Crear contenedor temporal de la base de datos');
//task('doctrine:docker:container:db', function () {
//	run(
//		'docker run --rm -d --name deployer_{{docker/project_name}}_db_temp idmarinas/{{docker/project_name}}:{{app/version}}'
//	);
//	run('docker cp deployer_{{docker/project_name}}_db_temp:/app/var/db.sql {{release_path}}/var/db.sql');
//	run('docker rm deployer_{{docker/project_name}}_db_temp');
//});

desc('Comprobar si se necesitan migraciones de Doctrine');
task('doctrine:check', function () {
	writeln('<info>Comprobando si se necesitan migraciones de Doctrine</>');

	try {
		run('{{bin/console}} doctrine:migrations:up-to-date', real_time_output: true);
		writeln('<info>No se necesitan migraciones de Doctrine</>');
		set('need_db_migration', false);
	} catch (Throwable) {
		writeln('<fg=yellow>Se necesitan migraciones de Doctrine</>');
		set('need_db_migration', true);
	}
});

desc('Ejecutar migraciones de Doctrine');
task('doctrine:migrate', function () {
	if (get('need_db_migration')) {
		writeln('<info>Activando el modo mantenimiento</>');
		try {
			invoke('migration:estimate:time');
		} catch (Throwable $e) {
			writeln('<fg=yellow>No se pudo estimar el tiempo de migración, usando valor por defecto</>');
			set('doctrine/migration/duration', '5m');
		}
		invoke('maintenance:on');

		writeln('<info>Ejecutando migraciones de Doctrine</>');
		run('{{bin/console}} doctrine:migrations:migrate {{migrations/options}}', real_time_output: true);
	}
});

desc('Estimar tiempo de migración real');
task('migration:estimate:time', function () {
	try {
		// 1. Obtener lista de migraciones pendientes
		$migrationsList = run('{{bin/console}} doctrine:migrations:list --no-interaction --no-ansi');

		preg_match_all('#(DoctrineMigrations\\\\Version[0-9]+)\s+\|\s+not migrated#im', $migrationsList, $matches);
		$pendingMigrations = $matches[1] ?? [];

		if (empty($pendingMigrations)) {
			writeln('<info>No hay migraciones pendientes</info>');

			return;
		}

		// 2. Estimar basado en migraciones pendientes
		$estimation = analyzeRealMigrationTime('', $pendingMigrations);

		writeln('<info>Estimación basada en datos reales:</info>');
		writeln("<comment>Tiempo estimado: <options=bold>{$estimation['duration']}</></comment>");
		writeln("<comment>Factores considerados: <options=bold>{$estimation['factors']}</></comment>");

		set('doctrine/migration/duration', $estimation['duration']);
	} catch (Throwable $e) {
		writeln("<fg=yellow>Advertencia: No se pudo estimar el tiempo de migración: {$e->getMessage()}</>");
		set('doctrine/migration/duration', '5m');
	}
});

desc('Ejecutar migraciones de Doctrine');
task('doctrine:migrations', [
	'doctrine:check',
	'doctrine:migrate',
]);

function analyzeRealMigrationTime(string $tableStats, array $migrations): array
{
	$factors = [];
	$estimatedSeconds = 5;

	// Parsear estadísticas de tablas para obtener volumen de datos
	$largeTableThreshold = 100000; // 100k registros
	$hugTableThreshold = 1000000;  // 1M registros

	// Factores de tiempo basados en operaciones y volumen
	$operationFactors = [
		// Operaciones en tablas vacías/pequeñas
		'CREATE TABLE'            => 2,
		'DROP TABLE'              => 2,
		'ADD COLUMN'              => 5,
		'DROP COLUMN'             => 3,

		// Operaciones que escalan con datos
		'ALTER TABLE.*ADD.*INDEX' => 30, // Base + factor por cada registro
		'CREATE INDEX'            => 45,
		'UPDATE.*SET'             => 20, // Muy dependiente del volumen
		'INSERT INTO.*SELECT'     => 25,
	];

	foreach ($migrations as $version) {
		$preview = run("{{bin/console}} doctrine:migrations:execute --up '$version' --dry-run -n --no-ansi -vv");

		// Analizar cada operación de las migraciones pendientes
		foreach ($operationFactors as $pattern => $baseTime) {
			if (preg_match_all("/$pattern/i", $preview, $matches)) {
				$occurrences = count($matches[0]);
				$estimatedSeconds += $occurrences * $baseTime;
				$factors[] = "{$occurrences}x $pattern operaciones";
			}
		}
	}

	// Ajustar por volumen de datos (esto es aproximado)
	if (str_contains($tableStats, 'users') && preg_match('/users.*?(\d+)/', $tableStats, $matches)) {
		$userCount = (int)$matches[1];
		if ($userCount > $largeTableThreshold) {
			$estimatedSeconds *= 2; // Duplicar tiempo para tablas grandes
			$factors[] = "Tabla de usuarios grande ($userCount registros)";
		}
		if ($userCount > $hugTableThreshold) {
			$estimatedSeconds *= 2; // Factor adicional para tablas muy grandes
			$factors[] = 'Detectada una tabla de usuarios enorme.';
		}
	}

	$estimatedSeconds *= 2;
	$factors[] = '100% de margen de seguridad aplicado'; // Las migraciones siempre tardan más de lo esperado

	writeln("<comment>Tiempo estimado segundos: <options=bold>$estimatedSeconds</></comment>");
	// Mínimo 30 segundos para cualquier migración
	$estimatedSeconds = max($estimatedSeconds, 90);

	// Convertir a formato legible
	if ($estimatedSeconds < 3600) {
		$duration = ceil($estimatedSeconds / 60).'m';
	} else {
		$duration = ceil($estimatedSeconds / 3600).'h';
	}

	return [
		'duration' => $duration,
		'factors'  => implode(', ', $factors),
	];
}
