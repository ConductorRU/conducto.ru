<?php
	use core\dc\DC;
	use app\model\Chat;
	$this->title = 'Поиск чатов';
	$this->AddReady('search.Restart(20, ' . Chat::MaxId() . '); main.SetScroll(function() { search.Scroll("chats"); });');
?>
<div class="conBar"><a class="pjax" href="/search">Поиск</a> <i class="fa fa-angle-right"></i> Чаты</div>
<?php if(count($chats)):
	$this->render('_list_chats', ['chats' => $chats]);
else: ?>
	Ни одного чата не найдено
<?php endif ?>