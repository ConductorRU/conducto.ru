<?php
	use core\DC\View;
	use back\updates\UpdateBase;
	$this->title = 'Обновление';
	$this->addJsFile('update.js', View::END);
	$this->addReady('$("#create").click(function() {upd.Create();});');
	$this->addReady('$("#update").click(function() {upd.Run();});');
	$files = UpdateBase::getFiles();
?>
<div class="updates"><?= $this->render('_update', ['files' => $files]) ?></div>
<div>
	<div class="inl"><input type="text" placeholder="Код обновления" id="name" /><div class="tip"></div></div>
	<button id="create">Создать</button> <button id="update">Обновить</button>
</div>