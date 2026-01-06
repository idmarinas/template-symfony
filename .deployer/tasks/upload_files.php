<?php

namespace Deployer;

desc('Upload files to server');
task('deploy:upload_files', function () {
	writeln('<fg=blue>Subiendo archivos a {{text_prod}}...</>');
	upload('./', '{{release_path}}', [
		'flags'   => '-azPh',
		'options' => [
			'--include=compose.yaml',
			'--include=compose.prod.yaml',
			'--exclude=**/*',
			'--chmod=F440',
		],
	]);
	writeln('<fg=blue>Subiendo {{docker/image/tar}} a {{text_prod}}...</>');
	upload('./.deployer/{{docker/image/tar}}', '{{release_path}}', [
		'options' => ['--chmod=F750'],
	]);
});
