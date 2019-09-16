<?php
	use core\dc\DC;
	$this->AddCSSFile('article.css');
	$this->AddJSFile('article.js');
	$this->AddReady('article.Prepare("#edit", "#edit + .popEdit")');
	$this->title = $article->name;
	$isOwn = DC::$app->user ? DC::$app->user->id == $article->creator : 0;
?>
<div class="con1 article">
	<div id="cont">
		<input type="hidden" data-type="article" value="<?= $article->id ?>" />
		<div class="conBar edit <?= ($article->status == 2) ? 'hidden' : '' ?>">
			<a class="pjax" href="/articles"><?= DC::t('Articles', 'article') ?></a>
			<i class="fa fa-angle-right"></i>
			<?= $article->name ?>
			<?php if($isOwn): ?>
			<i id="edit" class="fa fa-cog edit" title="Показать настройки"></i>
			<div class="popEdit">
				<div>
					<div><a class="pjax" href="<?= $article->GetUrl() ?>?action=edit">Редактировать</a></div>
					<div><span data-action="hide">Скрыть</span></div>
					<div><span data-action="show">Опубликовать</span></div>
					<div><span data-action="delete">Удалить</span></div>
				</div>
			</div>
			<?php endif ?>
		</div>
		<div class="conBody"><?= $this->render('_content', ['article' => $article]) ?></div>
	</div>
</div>