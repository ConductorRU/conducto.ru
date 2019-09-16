<?php
	use core\dc\DC;
	use app\model\User;
	$this->title = 'Поиск пользователей';
	$this->AddReady('search.Restart(20, ' . User::MaxId() . '); main.SetScroll(function() { search.Scroll("users"); });');
?>
<div class="conBar"><a class="pjax" href="/search">Поиск</a> <i class="fa fa-angle-right"></i> Пользователи</div>
<?php if(count($users)):
	$this->render('_list_users', ['users' => $users]);
else: ?>
	Ни одного пользователя не найдено
<?php endif ?>