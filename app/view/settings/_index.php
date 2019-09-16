<?php
	use core\dc\DC;
	$this->AddReady('$(".props a").click(function() {main.SlideProp(this); })');
	$this->AddReady('$(".settingsM button").click(function() {sets.SaveCommon(this); })');
?>
<div class="settings">
	<div>
		<label>Логин</label>
		<div><input type="text" name="login" value="<?= DC::$app->user->login ?>" /><div class="tip"></div></div>
	</div>
	<div>
		<label>Адрес электронной почты</label>
		<div><input type="text" name="email" value="<?= DC::$app->user->email ?>" /><div class="tip"></div></div>
	</div>
	<hr>
	<div class="setTip">Для изменения логина или адреса почты необходимо ввести текущий пароль</div>
	<div>
		<label>Текущий пароль</label>
		<div><input type="password" name="password" value="" placeholder="" /><div class="tip"></div></div>
	</div>
	<div>
		<label>Новый пароль</label>
		<div><input type="password" name="password_new" value="" placeholder="...если хотите изменить текущий" /><div class="tip"></div></div>
	</div>
	<div>
		<label>Подтверждение нового пароля</label>
		<div><input type="password" name="password_confirm" value="" /><div class="tip"></div></div>
	</div>
	<hr>
	<div class="settingsM">
		<button>Сохранить</button>
	</div>
</div>