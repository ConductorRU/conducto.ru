<?php
namespace app\controller;
use core\dc\Controller;
use core\dc\DC;
use app\model\User;
use app\model\Chat;
use app\model\Dialog;
class ChatController extends BaseController
{
	public function actionIndex()
	{
		$sel = isset(DC::$app->request->params['selector']) ? DC::$app->request->params['selector'] : '';
		$chat_id = isset(DC::$app->request->params['id']) ? (int)DC::$app->request->params['id'] : 0;
		$chat = null;
		$posts = [];
		if($chat_id)
		{
			$chat = Chat::LoadById($chat_id);
			if(!$chat)
				return $this->Error();
			$posts = $chat->GetPosts(0, 0, 20, true);
		}
		if($sel == '#cont')
		{
			$this->render('_form', ['chat' => $chat, 'posts' => $posts]);
			return;
		}
		$list = DC::$app->user ? Chat::GetList(DC::$app->user->id) : [];
		$this->render('index', ['chat' => $chat, 'posts' => $posts, 'list' => $list]);
	}
	public function actionIm()
	{
		$sel = isset(DC::$app->request->params['selector']) ? DC::$app->request->params['selector'] : '';
		$user_id = isset(DC::$app->request->params['id']) ? (int)DC::$app->request->params['id'] : 0;
		$dia = null;
		$posts = [];
		$user = null;
		if($user_id)
		{
			$user = User::GetById($user_id);
			if(!$user)
				return $this->Error();
			$dia = Dialog::LoadByUsers(DC::$app->user->id, $user_id);
			if($dia)
				$posts = $dia->GetPosts(0, 0, 20, true);
		}
		if($sel == '#cont')
		{
			$this->render('_form', ['user' => $user, 'dialog' => $dia, 'posts' => $posts]);
			return;
		}
		$list = Dialog::GetList(DC::$app->user->id);
		$this->render('im', ['user' => $user, 'dialog' => $dia, 'posts' => $posts, 'list' => $list]);
	}
}