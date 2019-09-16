<?php
namespace app\controller\post;
use core\dc\Controller;
use core\dc\DC;
use app\model\Friend;
class UserController extends Controller
{
	public function beforeAction()
	{
		$this->formatJson();
	}
	public function actionAddFriend()
	{
		$p = DC::$app->request->params;
		if(!isset($p['user_id']) || !isset($p['type']))
			return ['r' => 0, 'text' => 'Неверные входные параметры'];
		if(!DC::$app->user)
			return ['r' => 0, 'text' => 'Только зарегистрированные пользователи могут выполнять это действие'];
		$user_id = (int)$p['user_id'];
		$type = (int)$p['type'];
		if($type)
			$friend = Friend::AddFriend(DC::$app->user->id, $user_id);
		else
			$friend = Friend::RemoveFriend(DC::$app->user->id, $user_id);
		$text = $this->renderVar('../user/_friend_button', ['user_id' => $user_id, 'friend' => $friend]);
		return ['r' => 1, 'json' => $text];
	}
}