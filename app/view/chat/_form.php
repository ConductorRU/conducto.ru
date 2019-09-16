<?php
	use core\dc\DC;
	if(isset($user))
	{
		$this->title = $user->login;
		if($dialog)
			$this->AddReady('chat.InitIm(' . $dialog->user1 . ', ' . $dialog->user2 . ', ' . $dialog->GetLast() . ', "chat.Append()");');
		else
			$this->AddReady('chat.InitIm(' . DC::$app->user->id . ', ' . $user->id . ', 0, "chat.Append()");');
	}
	else
	{
		$this->title = $chat->name;
		$this->AddReady('chat.Init(' . $chat->id . ', ' . $chat->GetLast() . ', "chat.Append()");');
	}
	$this->AddReady('$("#send").click( function() {chat.Send();});');
?>
<div class="conBar"><?php if(isset($user) && !$user->IsYou()): ?><a class="pjax" href="<?= $user->GetUrl() ?>"><?= $user->login ?></a> <i class="fa fa-angle-right"></i> <?php endif ?><a class="pjax" href="/chat">Чаты</a> <i class="fa fa-angle-right"></i> <?= $this->title ?></div>
<div class="chat">
	<div id="chat"><?= $this->render('_posts', ['posts' => $posts]) ?></div>
	<div class="form">
		<div class="edit" id="sendM" contenteditable="true" placeholder="Введите сообщение"></div>
		<div class="buts">
			<button class="blu" id="send"><?= DC::t('Send', 'chat') ?></button>
		</div>
	</div>
</div>