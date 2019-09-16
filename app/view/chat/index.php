<?php
	use core\dc\DC;
	$this->title = 'Чаты';
	$this->AddCSSFile('chat.css');
	$this->AddJSFile('chat.js');
?>
<?php if(false): ?>
<div class="con1">
	<div id="cont">
		<div class="conBar"><?php if(!$user->IsYou()): ?><a class="pjax" href="<?= $user->GetUrl() ?>"><?= $user->login ?></a> <i class="fa fa-angle-right"></i> <?php endif ?>Чаты</div>
		<div class="central">Выберите чат справа</div>
	</div>
</div>
<?php else: ?>
<div class="con2">
	<div id="cont">
		<?php if($chat): $this->render('_form', ['chat' => $chat, 'posts' => $posts]); else:
		?><div class="central">Выберите чат справа</div><?php endif; ?>
	</div>
	<div class="sidebar"><?php $this->render('_sidebar', ['list' => $list]); ?></div>
</div>
<?php endif;