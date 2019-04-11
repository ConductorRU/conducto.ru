<?php
	use core\DC\View;
	use back\updates\UpdateBase;
	$this->title = 'Обновление';
	$this->addJsFile('update.js', View::END);
	$files = UpdateBase::getFiles();
?>
<div id="vUpdate">
	<div class="updates"><?= $this->render('_update', ['files' => $files]) ?></div>
	<div>
		<div class="inl"><input type="text" placeholder="Код обновления" v-model="updateName" /><div class="tip"></div></div>
		<button v-on:click="Create">Создать</button> <button v-on:click="Update">Обновить</button>
	</div>
</div>