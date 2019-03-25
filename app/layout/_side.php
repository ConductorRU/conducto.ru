<?php
if($user): ?><aside id="side">
	<a class="pjax" href="/friends"><span>Друзья</span><i class="fa fa-users"><span></span></i></a>
	<a class="pjax" href="/im"><span>Диалоги</span><i class="fa fa-envelope"><span></span></i></a>
	<a class="pjax" href="/chat"><span>Чаты</span><i class="fa fa-comments"><span></span></i></a>
	<a class="pjax" href="/albums"><span>Фотоальбомы</span><i class="fa fa-film"><span></span></i></a>
	<a class="pjax" href="/articles"><span>Статьи</span><i class="fa fa-graduation-cap"><span></span></i></a>
	<a class="pjax" href="/tasks"><span>Задачи</span><i class="fa fa-tasks"><span></span></i></a>
	<a class="pjax" href="/settings"><span>Настройки</span><i class="fa fa-cogs"></i></a>
</aside>
<?php
//$this->AddReady('$("#side a").click( function() {$(".userbar").addClass("nohov");}); $("#side a").mouseover( function() {$(".userbar").removeClass("nohov");})');
else:
?>
<aside id="side">
	<a class="pjax" href="/search/users"><span>Пользователи</span><i class="fa fa-users"><span></span></i></a>
	<a class="pjax" href="/search/chats"><span>Чаты</span><i class="fa fa-comments"><span></span></i></a>
	<a class="pjax" href="/search/articles"><span>Статьи</span><i class="fa fa-graduation-cap"><span></span></i></a>
	<a class="pjax" href="/search/tasks"><span>Задачи</span><i class="fa fa-tasks"><span></span></i></a>
</aside>
<?php endif ?>