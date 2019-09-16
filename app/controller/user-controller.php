<?php
namespace app\controller;
use core\dc\DC;
use core\dc\Controller;
use app\model\User;

class UserController extends BaseController
{
	public function actionIndex()
	{
		$id = isset(DC::$app->request->params['id']) ? (int)DC::$app->request->params['id'] : 0;
		if(!$id)
			return $this->Error();
		$user = User::GetById($id);
		if(!$user)
			return $this->Error();
		$this->render('index', ['user' => $user]);
	}
}