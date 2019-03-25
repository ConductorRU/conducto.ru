<?php
use core\dc\DC;
$this->title = 'Регистрация';
$this->AddReady('$("#eReg button").click( function() {main.Reg();});');
$this->AddReady('$("button[name=\'enter\']").click( function() {main.Enter();});');
?>
<div class="con1">
	<div class="eReg">
		<div id="eEnter">
			<div><h1>Вход</h1></div>
			<div><input type="text" name="email" autocomplete="on" placeholder="Почта" /><label></label></div>
			<div><input type="password" name="password" placeholder="Пароль" /><label></label></div>
			<div><button class="blu wide" name="enter">Войти</button></div>
		</div>
		<div id="eReg">
			<div class="center"><hr><span>Еще не зарегистрированы?</span></div>
			<div><h1><?= $this->title ?></h1></div>
			<div><input type="text" name="login" autocomplete="off" placeholder="Логин" /><label></label></div>
			<div><input type="text" name="email" autocomplete="on" placeholder="Почта" /><label></label></div>
			<div><input type="password" name="password" autocomplete="off" placeholder="Пароль" /><label></label></div>
			<div><button class="blu wide">Зарегистрироваться</button></div>
		</div>
	</div>
</div>