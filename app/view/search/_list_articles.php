<?php foreach($articles as $article):
?><div>
	<div>
		<div class="img"><a class="pjax" href="<?= $article->GetUrl() ?>"><img src="" alt="" width="100px" height="100px" /></a></div>
		<div class="con">
			<div class="name"><a class="pjax" href="<?= $article->GetUrl() ?>"><?= $article->name ?></a></div>
		</div>
	</div>
</div><?php endforeach ?>