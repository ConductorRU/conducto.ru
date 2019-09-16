<?php
	use core\dc\DC;
	use app\model\Article;
	$this->title = 'Поиск статей';
	$this->AddReady('search.Restart(20, ' . Article::MaxId() . '); main.SetScroll(function() { search.Scroll("articles"); });');
?>
<div class="conBar"><a class="pjax" href="/search">Поиск</a> <i class="fa fa-angle-right"></i> Статьи</div>
<?php if(count($articles)):
	$this->render('_list_articles', ['articles' => $articles]);
else: ?>
	Ни одной статьи не найдено
<?php endif ?>