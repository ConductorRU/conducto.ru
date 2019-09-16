<?php
	use core\dc\DC;
	$this->title = 'Диалоги';
	$this->AddCSSFile('chat.css');
	$this->AddJSFile('chat.js');
?>
<?php if(false): ?>
<div class="con1">
	<div id="cont">
		<div class="central">Выберите пользователя справа</div>
	</div>
</div>
<?php else: ?>
<div class="con2">
	<div id="cont">
		<?php if($user): $this->render('_form', ['user' => $user, 'dialog' => $dialog, 'posts' => $posts]);
		else: ?><div class="central">Выберите диалог справа</div><?php endif; ?>
	</div>
	<div class="sidebar"><?php $this->render('_sidebar_im', ['list' => $list]); ?></div>
</div>
<?php endif ?>