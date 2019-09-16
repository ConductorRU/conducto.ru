<?php
	use core\dc\DC;
	$this->AddCSSFile('album.css');
	$this->AddJSFile('album.js');
	$this->title = DC::t('Albums', 'album');
?>
<div class="con1">
	<div id="cont">
		<div class="conBar"><?= DC::t('Albums', 'album') ?><a class="pjax add" href="/album/create"><i class="fa fa-plus"></i><?= DC::t('Add a new album', 'album') ?></a></div>
		<div class="photoList">
			<?php for($i = 0; $i < 10; ++$i):
			?><div>
				<a href="#">
					<span class="img"></span>
					<span class="name single">Фото <?= $i ?></span>
				</a>
			</div><?php endfor ?>
		</div>
	</div>
</div>