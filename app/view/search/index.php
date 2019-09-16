<?php
	use core\dc\DC;
	$this->AddJSFile('search.js');
	$this->AddReady('$(".props a").click(function() {main.SlideProp(this); })');
	$this->title = 'Поиск';
?>
<div class="con2">
	<div id="cont" class="search">
		<?= $this->render($render, $data) ?>
	</div>
	<div class="sidebar scrollwhite sideprops">
		<div class="props">
			<a class="pjax<?= ($render == '_index') ? ' sel' : '' ?>" data-target="#cont" href="/search/index">Поиск</a>
			<a class="pjax<?= ($render == '_users') ? ' sel' : '' ?>" data-target="#cont" href="/search/users">Пользователи</a>
			<a class="pjax<?= ($render == '_chats') ? ' sel' : '' ?>" data-target="#cont" href="/search/chats">Чаты</a>
			<a class="pjax<?= ($render == '_tasks') ? ' sel' : '' ?>" data-target="#cont" href="/search/tasks">Задачи</a>
		</div>
		<div class="mark"></div>
	</div>
</div>