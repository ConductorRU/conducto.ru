<?php
namespace app\model;
use core\dc\Model;
use core\dc\DC;
class Chat extends Im
{
	const ENTITY_TYPE = 2;
	public static function LoadById($id)
	{
		return Chat::FindWhere('id=' . $id);
	}
	public static function Create($name, $user_id = 0)
	{
		if(!$user_id && DC::$app->user && DC::$app->user->id)
			$user_id = DC::$app->user->id;
		if(!$user_id)
			return null;
		$chat = new Chat;
		$chat->wall_id = Wall::CreateId();
		$chat->entity_id = Entity::CreateId();
		$chat->name = $name;
		$chat->status = 1;
		$chat->creator = $user_id;
		$chat->created_at = $chat->updated_at = date('Y-m-d H:i:s');
		$chat->save();
		if($chat->id)
			return $chat;
		return null;
	}
	public function GetUrl()
	{
		return '/chat' . $this->id;
	}
	public static function MaxId()
	{
		return User::FindOne('MAX(id)');
	}
	public static function GetList($user_id, $start = 0, $count = 20)
	{
		$type = EntityType::GetIdByName('chat');
		$chats = Chat::SelectAll('chat.*', 'RIGHT JOIN subscribe ON subscribe.entity_id = chat.entity_id WHERE subscribe.user_id=' . $user_id . ' AND subscribe.entity_type=' . $type . ' ORDER BY chat.updated_at LIMIT ' . $start . ' , ' . $count);
		foreach($chats as &$chat)
		{
			$chat->post = $chat->GetLastPost();
			$chat->user = $chat->post ? User::GetById($chat->post->creator) : null;
		}
		return $chats;
	}
	public function GetLastPost()
	{
		return Post::Select('*', 'WHERE wall_id=' . $this->wall_id . ' ORDER BY id DESC LIMIT 1');
	}
	public function GetImage()
	{
		return '/img/nophoto.png';
	}
}