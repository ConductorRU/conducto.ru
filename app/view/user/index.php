<?php
	use app\model\Friend;
	use core\dc\DC;
	$us = DC::$app->user;
	$isYou = ($us && $us->id == $user->id);
	$fCount = Friend::GetCount($user->id);
	$friends = Friend::GetUsers($user->id);
	$this->title = $user->login;
	$this->AddJSFile('photo.js');
	$this->AddCSSFile('photo.css');
	$this->AddReady('$("#photoLoad").click( function() {photo.Open();});');
	$this->AddCode($this->renderBuffer('_photo'));
?>
<div class="con2">
	<div id="cont">
		<div class="conBar"><?= $user->login ?></div>
	</div>
	<div class="sidebar scrollwhite">
		<div class="img">
			<img src="/img/nophoto.png" width="240px" height="240px" alt="Фото профиля" />
			<?php if($isYou): ?><div id="photoLoad" class="edit">Загрузить новое фото</div><?php endif ?>
		</div>
		<?php if(!$isYou):
			if($us && $us->id && $user->id):
				$friend = Friend::Get($us->id, $user->id);
				echo '<div id="sFriend">' . $this->render('_friend_button', ['user_id' => $user->id, 'friend' => $friend]) . '</div>';
			endif;
		endif; ?>
		<div class="sFriends">
			<div class="header"><a class="pjax" href="<?= Friend::GetUrl($user->id) ?>">Друзья <span><?= $fCount ?></span></a></div>
			<div class="body"><?php
			foreach($friends as $f):
				?><div><a class="pjax" href="/id1"><span><img width="57px" height="57px" alt="" /></span><span class="name" title="<?= htmlentities($f->login) ?>"><?= htmlentities($f->login) ?></span></a></div><?php
			endforeach; ?></div>
		</div>
	</div>
</div>