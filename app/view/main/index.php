<?php
use core\dc\DC;
$this->title = 'Хронополис';
if(isset($alert)):
	echo $alert;
elseif(DC::$app->user):
	$this->render('../user/index', ['user' => DC::$app->user]);
else:
	$this->render('reg');
endif;