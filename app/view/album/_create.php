<?php 
use core\dc\DC;
$this->title = DC::t('New album', 'album');
$this->AddCSSFile('album.css');
$this->AddJSFile('album.js');
$this->AddReady('album.Ready();');
$status = isset($album) ? $album->status : 0;
?>
<div class="conBar">
	<a class="pjax" href="/albums"><?= DC::t('Albums', 'album') ?></a>
	<i class="fa fa-angle-right"></i>
	<?php if(isset($album)): ?>
	<a class="pjax" href="<?= $album->GetUrl() ?>"><?= $album->name ?></a>
	<i class="fa fa-angle-right"></i>
	<?php endif ?>
	<?= isset($album) ? DC::t('Edit album', 'album') : DC::t('New album', 'album') ?>
</div>
<div>
	<div class="settings">
		<input type="hidden" name="id" value="<?= isset($album) ? $album->id : 0 ?>" />
		<div>
			<label>Название<span>*</span></label>
			<div><input type="text" name="name" <?= isset($album) ? 'value="' . addcslashes($album->name, '"') . '"' : '' ?>><div class="tip"></div></div>
		</div>
		<div>
			<label>Статус</label>
			<div>
				<select name="status">
					<option value="1" <?= ($status == 1) ? 'selected="selected"' : '' ?>>Видно всем</option>
					<option value="2" <?= ($status == 2) ? 'selected="selected"' : '' ?>>Скрыто</option>
				</select>
				<div class="tip"></div>
			</div>
		</div>
		<div>
			<label>Краткое описание</label>
			<div><div class="textbox" name="desc" contenteditable="true"><?= isset($album) ? $album->description : '' ?></div></div>
		</div>
		
		<div class="settingsM">
			<button id="saveAlbum">Сохранить</button>
		</div>
	</div>
</div>