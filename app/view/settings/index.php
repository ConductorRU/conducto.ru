<?php
	use core\dc\DC;
	$this->AddJSFile('settings.js');
	$this->AddReady('$(".props a").click(function() {main.SlideProp(this); })');
?>
<div class="con2">
	<div id="cont">
		<?= $this->render($render) ?>
	</div>
	<div class="sidebar scrollwhite sideprops">
		<div class="props">
			<a class="pjax<?= ($render == '_index') ? ' sel' : '' ?>" data-target="#cont" href="/settings">Основные настройки</a>
			<a class="pjax<?= ($render == '_info') ? ' sel' : '' ?>" data-target="#cont" href="/settings/info">Личные данные</a>
			<a class="pjax<?= ($render == '_contact') ? ' sel' : '' ?>" data-target="#cont" href="/settings/contact">Контактная информация</a>
			<a class="pjax<?= ($render == '_about') ? ' sel' : '' ?>" data-target="#cont" href="/settings/about">Интересы</a>
		</div>
		<div class="mark"></div>
	</div>
</div>