<?php
	use core\dc\DC;
	$this->AddCSSFile('article.css');
	$this->AddJSFile('article.js');
	$this->title = DC::t('Articles', 'article');
?>
<div class="con1">
	<div id="cont">
		<div class="conBar"><?= DC::t('Articles', 'article') ?></div>
		<div class="itemList">
			<div class="create">
				<div class="img"><a class="pjax" href="/article/create">+</a></div>
				<div class="desc">
					<div class="name"><a class="pjax" href="/article/create"><?= DC::t('Create a new article', 'article') ?></a></div>
				</div>
			</div>
			<?php foreach($articles as $art): ?>
			<div <?= $art->status == 2 ? 'class="hidden"': '' ?>>
				<div class="img"><a class="pjax" href="<?= $art->GetUrl() ?>"></a></div>
				<div class="desc">
					<div class="name"><a class="pjax" href="<?= $art->GetUrl() ?>"><?= $art->name ?></a><?php if($art->status == 2): ?><i class="fa fa-eye-slash" title="Статья не опубликована"></i><?php endif ?></div>
					<div class="text"><?= $art->description ?></div>
				</div>
			</div>
			<?php endforeach ?>
		</div>
	</div>
</div>