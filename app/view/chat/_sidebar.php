<?php
	use core\dc\DC;
	$this->AddReady('chat.SideChat();');
?>
<div class="chatSide">
<?php foreach($list as $li):
	$name = '<span class="guest">Гость</span>';
	if($li->user)
		$name = '<a class="pjax" href="/id' . $li->user->id . '">' . $li->user->login . '</a>';
	$time = strtotime($li->post->created_at);
	if(date('Y-m-d') == date('Y-m-d', $time))
		$t = date('H:i:s', $time);
	else
		$t =  date('d.m.Y', $time);
?><div data-chat="<?= $li->id ?>">
	<div></div>
	<div>
		<div class="time"><?= $t ?></div><div class="name"><?= $li->name ?></div>
		<div class="text"><span class="name"><?= $name ?></span>: <?= $li->post->text ?></div>
	</div>
</div><?php endforeach ?>
</div>