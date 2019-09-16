<?php
	use core\dc\DC;
	use app\model\Attribute;
	use app\model\User;
	$user = DC::$app->user;
?>
<div class="settings">
	<div>
		<label>Имя</label>
		<div><input type="text" name="firstname" value="<?= Attribute::GetValue(User::ENTITY_TYPE, $user->entity_id, 1) ?>" /></div>
	</div>
	<div>
		<label>Фамилия</label>
		<div><input type="text" name="surname" value="<?= Attribute::GetValue(User::ENTITY_TYPE, $user->entity_id, 2) ?>" /></div>
	</div>
	<div>
		<label>Отчество</label>
		<div><input type="text" name="patroname" value="<?= Attribute::GetValue(User::ENTITY_TYPE, $user->entity_id, 3) ?>" /></div>
	</div>
	<div>
		<label>Дата рождения</label>
		<div><input type="text" name="login" value="" /></div>
	</div>
	<div>
		<label>Родной город</label>
		<div><input type="text" name="city" value="" /></div>
	</div>
	<div class="settingsM">
		<button>Сохранить</button>
	</div>
</div>