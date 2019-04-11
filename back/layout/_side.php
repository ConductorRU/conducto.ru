<?php
	use core\DC\DC;
	use core\DC\View;
	$url = DC::$app->request->url;
	$refs =
	[
		['url' => '', 'icon' => 'fa-user-circle', 'name' => 'Главная'],
		['url' => 'update', 'icon' => 'fa-refresh', 'name' => 'Обновления'],
	];
?>
<aside>
<?php foreach($refs as $ref): ?>
	<a href="/admin<?= $ref['url'] ? '/' . $ref['url'] : '' ?>" <?= ($url == $ref['url']) ? 'class="sel"': '' ?>><i class="fa <?= $ref['icon'] ?>"></i> <?= $ref['name'] ?></a><?php endforeach ?>
</aside>