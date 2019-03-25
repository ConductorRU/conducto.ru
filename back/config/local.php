<?php
$config =
[
	'web' => 'admin',
	'route' =>
	[
		'' => 'main',
		'update' => 'main/update',
		'post/<controller>/<action>' => 'post/<controller>/<action>',
	],
	'css' => ['css/main.css'],
	'js' => ['js/main.js'],
];