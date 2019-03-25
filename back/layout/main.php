<?php
?>
<!DOCTYPE html>
<html>
	<head>
		<title><?= $this->title ?></title>
		<link rel="shortcut icon" href="/admin/favicon.ico" type="image/x-icon">
		<?= $this->head() ?>
	</head>
	<body>
	<?php $this->beginBody() ?>
		<div class="wrap">
			<header><?= $this->render('_header') ?></header>
			<div class="main">
				<div class="userbar scrollwhite"><?= $this->render('_side') ?></div>
				<div id="content"><?= $content ?></div>
				<div id="error"><i class="fa fa-times"></i><div></div></div>
			</div>
			<footer></footer>
		</div>
	<?php $this->endBody() ?>
	</body>
</html>