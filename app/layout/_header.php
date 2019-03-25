<?php
use Core\DC\DC;
$user = DC::$app->user; ?>
<page class="head">
	<a class="pjax" id="logo" href="/" title="Главная страница"><img src="/img/logo.png" alt="" /></a><user><?php if($user):
	?><a class="pjax" href="/"><img /><name><?= $user->login ?></name></a><?php else:
	?><a class="reg pjax" href="/reg">Вход/Регистрация</a><?php
	endif ?></user>
	<?php if($user): ?><div class="logout"><a href="/logout">Выход</a></div><?php endif ?>
	<div class="search"><input type="text" autocomplete="off" /><a href="/search"><i class="fa fa-search"></i></a></div>
</page>