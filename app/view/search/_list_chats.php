<?php foreach($chats as $chat):
?><div>
	<div>
		<div class="img"><a class="pjax" href="<?= $chat->GetUrl() ?>"><img src="<?= $chat->GetImage() ?>" alt="" width="100px" height="100px" /></a></div>
		<div class="con">
			<div class="name"><a class="pjax" href="<?= $chat->GetUrl() ?>"><?= $chat->name ?></a></div>
		</div>
	</div>
</div><?php endforeach ?>