<?php
namespace app\controller\post;
use core\dc\Controller;
use core\dc\DC;
use app\model\Chat;
use app\model\Anonym;
use app\model\Dialog;
use app\model\User;
use app\model\EntityType;
use app\model\Subscribe;
class ChatController extends Controller
{
	public $anonym = null;
	public function beforeAction()
	{
		$this->formatJson();
		$this->anonym = Anonym::Get(true);
	}
	public function actionSend()
	{
		$p = DC::$app->request->params;
		if(!isset($p['text']))
			return ['r' => 0, 'text' => 'Неверные входные параметры'];
		$p['text'] = preg_replace('/\<script.*?\<\/script\>/', '', $p['text']);
		$p['text'] =  preg_replace('/<([a-z][a-z0-9]*)[^>](on.*?=".*?")+(\/?)>/i','<$1$3>', $p['text']);
		$user_id = null;
		if(DC::$app->user && DC::$app->user->id)
			$user_id = DC::$app->user->id;
		$anonymId = null;
		if($this->anonym)
			$anonymId = $this->anonym->id;
		if(isset($p['chat_id']))
		{
			$chatId = (int)$p['chat_id'];
			$chat = Chat::LoadById($chatId);
			if(!$chat)
				return ['r' => 0, 'text' => 'Чат с номером ' . $chatId . ' не найден'];
			$post = $chat->AddPost($p['text'], $user_id, $anonymId);
			if($post)
			{
				$chat->updated_at = date('Y-m-d H:i:s');
				$chat->update();
				if($user_id)
					Subscribe::Add($user_id, $chat->entity_id, EntityType::GetIdByName($chat->tableName));
				DC::$app->mem->add('chat' . $chatId, $post->id, 10);
			}
		}
		else if(isset($p['user1']) && isset($p['user2']))
		{
			$user1 = (int)$p['user1'];
			$user2 = (int)$p['user2'];
			$dia = Dialog::LoadByUsers($user1, $user2);
			if(!$dia)
			{
				$dia = Dialog::Create($user1, $user2);
				if(!$dia)
					return ['r' => 0, 'text' => 'Ошибка создания диалога'];
			}
			$post = $dia->AddPost($p['text'], $user_id, $anonymId);
			if($post)
			{
				$dia->updated_at = $post->created_at;
				$dia->Update();
				DC::$app->mem->add('im_' . $dia->user1 . '_' . $dia->user2, $post->id, 10);
			}
		}
		else
			return ['r' => 0, 'text' => 'Неверные входные параметры'];
		return ['r' => 1];
	}
}