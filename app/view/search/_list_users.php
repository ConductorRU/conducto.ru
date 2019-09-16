<?php foreach($users as $user):
?><div>
	<div>
		<div class="img"><a class="pjax" href="<?= $user->GetUrl() ?>"><img src="" alt="" width="100px" height="100px" /></a></div>
		<div class="con">
			<div class="name"><a class="pjax" href="<?= $user->GetUrl() ?>"><?= $user->login ?></a></div>
		</div>
	</div>
</div><?php endforeach ?>