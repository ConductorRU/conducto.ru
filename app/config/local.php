<?php
use core\dc\View;
$config =
[
	'lang' => 'ru-RU',
	'route' =>
	[
		'' => 'main',
		'long' => 'long/index',
		'vk' => 'main/vk',
		'listen' => 'long/listen',
		'reg' => 'main/reg',
		'tasks' => 'task/tasks',
		'albums' => 'album/albums',
		'articles' => 'article/articles',
		'login' => 'main/login',
		'logout' => 'main/logout',
		'signup' => 'main/signup',
		'confirm' => 'main/confirm',
		'settings' => 'settings/index',
		'settings/<action>' => 'settings/<action>',
		'search' => 'search/index',
		'search/<action>' => 'search/<action>',
		'article/<action>' => 'article/<action>',
		'album/<action>' => 'album/<action>',
		'im<id:\d*>' => 'chat/im',
		'id<id:\d+>' => 'user/index',
		'chat<id:\d*>' => 'chat/index',
		'task<id:\d+>' => 'task/index',
		'article<id:\d+>' => 'article/index',
		'friends<id:\d*>' => 'friends/index',
		'friends<id:\d+>/<action>' => 'friends/<action>',
		'post/<controller>/<action>' => 'post/<controller>/<action>',
	],
	'css' => ['css/main.min.css'],
	'js' => ['js/main.js' => ['pos' => View::END], 'js/chat.js' => ['pos' => View::END]],
];