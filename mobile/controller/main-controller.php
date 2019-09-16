<?php
namespace mobile\controller;
use core\dc\DC;
use core\dc\Controller;
use core\dc\Mailer;
use app\model\User;

class MainController extends BaseController
{
	public function actionIndex()
	{
		$m = ['r' => 1, 'text' => 'Супер!'];
		return $m;
	}
}