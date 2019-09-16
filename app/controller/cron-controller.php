<?php
namespace app\controller;
use core\dc\Controller;
use app\model\User;
class CronController extends BaseController
{
	public function actionIndex()
	{
		$db = DC::$app->db;
		$this->render('index', ['chat' => $chat, 'posts' => $posts]);
	}
}