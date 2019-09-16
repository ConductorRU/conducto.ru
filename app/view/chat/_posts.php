<?php foreach($posts as $post):
	$user = $post->GetUser();
?>
	<div>
		<div class="chatL">
			<div class="img"><img src="" alt="" /></div>
		</div>
		<div class="chatR">
			<div class="date"><?= $post->GetCreatedAt() ?></div>
		</div>
		<div class="chatC">
			<div class="name"><span><?php if($user): ?><a class="pjax" href="<?= $user->GetUrl() ?>"><?= $user->login ?></a><?php else: ?>Гость<?php endif ?></span></div>
			<div class="text"><?= $post->GetText() ?></div>
		</div>
	</div>
<?php endforeach ?>