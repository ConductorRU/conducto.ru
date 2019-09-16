<?php
	use core\dc\DC;
	$this->AddReady('chat.SideDialog();');
?>
<div class="chatSide">
<?php foreach($list as $li):
	$name = '<span class="guest">Гость</span>';
	if($li->user)
		$name = '<a class="pjax" href="/id' . $li->user->id . '">' . $li->user->login . '</a>';
	$time = strtotime($li->post_created_at);
	if(date('Y-m-d') == date('Y-m-d', $time))
		$t = date('H:i:s', $time);
	else
		$t =  date('d.m.Y', $time);
?><div data-user1="<?= $li->user1 ?>" data-user2="<?= $li->user2 ?>">
	<div></div>
	<div>
		<div class="time"><?= $t ?></div><div class="name"><?= $name ?></div>
		<div class="text"><?= $li->post_text ?></div>
	</div>
</div><?php endforeach ?>
</div>