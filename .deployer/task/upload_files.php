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
});
