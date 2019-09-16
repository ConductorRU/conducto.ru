<?php 
use core\dc\DC;
$this->title = DC::t('New article', 'article');
$this->AddCSSFile('article.css');
$this->AddJSFile('article.js');
$this->AddReady('article.Ready();main.FormatBox("#formatButs", "#formatBox");');
$status = isset($article) ? $article->status : 0;
?>
<div class="conBar">
	<a class="pjax" href="/articles"><?= DC::t('Articles', 'article') ?></a>
	<i class="fa fa-angle-right"></i>
	<?php if(isset($article)): ?>
	<a class="pjax" href="<?= $article->GetUrl() ?>"><?= $article->name ?></a>
	<i class="fa fa-angle-right"></i>
	<?php endif ?>
	<?= isset($article) ? DC::t('Edit article', 'article') : DC::t('New article', 'article') ?>
</div>
<div>
	<div class="settings short">
		<input type="hidden" name="id" value="<?= isset($article) ? $article->id : 0 ?>" />
		<div>
			<label>Название<span>*</span></label>
			<div><input type="text" name="name" <?= isset($article) ? 'value="' . addcslashes($article->name, '"') . '"' : '' ?>><div class="tip"></div></div>
		</div>
		<div>
			<label>Статус</label>
			<div>
				<select name="status">
					<option value="1" <?= ($status == 1) ? 'selected="selected"' : '' ?>>Опубликовано</option>
					<option value="2" <?= ($status == 2) ? 'selected="selected"' : '' ?>>Черновик</option>
				</select>
				<div class="tip"></div>
			</div>
		</div>
		<div>
			<label>Краткое описание</label>
			<div><div class="textbox" name="desc" contenteditable="true"><?= isset($article) ? $article->description : '' ?></div></div>
		</div>
		<div>
			<label>Содержание</label>
			<div>
				<div id="formatButs" class="formatbox">
					<i href="#" class="fa fa-bold" data-cmd="bold" title="Полужирный шрифт"></i>
					<i class="fa fa-italic" data-cmd="italic" title="Курсив"></i>
					<i class="fa fa-strikethrough" data-cmd="strikeThrough" title="Зачеркнутый текст"></i>
					<i class="fa fa-underline" data-cmd="underline" title="Подчеркнутый текст"></i>
					<span>|</span>
					<i class="fa fa-align-left" data-cmd="justifyLeft" title="Выравнивание по левому краю"></i>
					<i class="fa fa-align-center" data-cmd="justifyCenter" title="Выравнивание по центру"></i>
					<i class="fa fa-align-right" data-cmd="justifyRight" title="Выравнивание по правому краю"></i>
					<i class="fa fa-align-justify" data-cmd="justifyFull" title="Выравнивание по ширине"></i>
					<span>|</span>
					<i class="fa fa-indent" data-cmd="indent" title="Добавить отступ"></i>
					<i class="fa fa-outdent" data-cmd="outdent" title="Убрать отступ"></i>
					<i class="fa fa-list-ul" data-cmd="insertUnorderedList" title="Список"></i>
					<i class="fa fa-list-ol" data-cmd="insertOrderedList" title="Нумерованный список"></i>
					<span>|</span>
					<i class="fa fa-heading" data-cmd="h2" title="Заголовок"></i>
					<i class="fa fa-eraser" data-cmd="div" title="Отменить заголовок"></i>
					<span>|</span>
					<i class="fa fa-code" data-cmd="code" title="Пример кода"></i>
				</div>
				<div id="formatBox" class="textbox contentbox" name="content" contenteditable="true"><?= isset($article) ? $article->GetFormatContent(1) : '' ?></div>
			</div>
		</div>
		<div class="settingsM">
			<button id="saveArticle">Сохранить</button>
		</div>
	</div>
</div>