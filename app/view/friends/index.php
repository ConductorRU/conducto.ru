<?php
	use app\model\Friend;
	use core\dc\DC;
	$this->title = 'Друзья | ' . $user->login;
?>
<div class="con2">
	<div id="cont">
		<div class="conBar"><?php if(!$user->IsYou()): ?><a class="pjax" href="<?= $user->GetUrl() ?>"><?= $user->login ?></a> <i class="fa fa-angle-right"></i> <?php endif ?>Друзья</div>
		<div class="friends">
		<?php foreach($friends as $f):
		?><div>
			<div class="img"><div><a class="pjax" href="<?= $f->GetUrl() ?>"><img src="/img/nophoto.png" width="120px" height="120px" alt="" /></a></div></div>
			<div class="desc">
				<div class="name"><a class="pjax" href="<?= $f->GetUrl() ?>"><?= $f->login ?></a></div>
			</div>
		</div><?php endforeach ?>
		<?php if(!count($friends)): ?><div class="central">У пользователя нет друзей</div><?php endif ?>
		</div>
	</div>
	<div class="sidebar scrollwhite">
	
	</div>
</div>