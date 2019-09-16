<?php
namespace app\controller;
use core\dc\Controller;
use core\dc\DC;
use app\model\Task;
class TaskController extends BaseController
{
	public function actionIndex()
	{
		$this->render('index', ['chat' => $chat, 'posts' => $posts]);
	}
	public function actionTasks()
	{
		$this->render('tasks');
	}
}