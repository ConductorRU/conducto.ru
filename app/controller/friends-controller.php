<?php
namespace app\controller;
use core\dc\Controller;
use core\dc\DC;
use app\model\User;
use app\model\Friend;
class FriendsController extends Controller
{
	public function actionIndex()
	{
		$p = DC::$app->request->params;
		$user_id = isset($p['id']) ? (int)$p['id'] : 0;
		if(!$user_id && (!DC::$app->user || !DC::$app->user->id))
			return $this->Error();
		$user = DC::$app->user;
		if($user_id)
			$user = User::GetById($user_id);
		if(!$user)
			return $this->Error();
		$friends = Friend::GetUsers($user->id);
		$this->render('index', ['user' => $user, 'friends' => $friends]);
	}
}