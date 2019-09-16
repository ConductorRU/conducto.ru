<?php
	use core\dc\DC;
	$this->title = 'Поиск задач';
?>
<div class="conBar"><a class="pjax" href="/search">Поиск</a> <i class="fa fa-angle-right"></i> Задачи</div>
<?php if(count($tasks)): ?>
	<?php foreach($tasks as $task): ?><div>
		<div>
			<div class="img"><a class="pjax" href="<?= $task->GetUrl() ?>"><img src="" alt="" width="100px" height="100px" /></a></div>
			<div class="con">
				<div class="name"><a class="pjax" href="<?= $task->GetUrl() ?>"><?= $task->name ?></a></div>
			</div>
		</div>
	</div><?php endforeach ?>
<?php else: ?>
	<div class="central">Ни одной задачи не найдено</div>
<?php endif ?>