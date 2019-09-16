<?php
namespace app\model;
use core\dc\Model;
class Dialog extends Im
{
	public static function LoadByUsers($user1, $user2)
	{
		return Dialog::FindWhere('(user1=' . $user1 . ' AND user2=' . $user2 . ') OR (user1=' . $user1 . ' AND user2=' . $user2 . ')');
	}
	public static function Create($user1, $user2)
	{
		$wall = new Wall;
		$wall->Save();
		$d = new Dialog;
		$d->user1 = $user1;
		$d->user2 = $user2;
		$d->start1 = 0;
		$d->start2 = 0;
		$d->wall_id = $wall->id;
		$d->created_at = $d->updated_at = date('Y-m-d H:i:s');
		$d->Save();
		return $d;
	}
	public static function GetList($user_id, $count = 20)
	{
		$list = Dialog::SelectAll('dialog.*, post.creator as post_user_id, post.text as post_text, post.created_at as post_created_at, user.id as user_id, user.login as user_login',
			'INNER JOIN post ON post.id = (SELECT MAX(id) FROM post WHERE wall_id = dialog.wall_id) LEFT JOIN user ON post.creator = user.id WHERE (user1=' . $user_id . ' OR user2=' . $user_id . ') ORDER BY post_created_at DESC LIMIT ' . $count);
		foreach($list as &$li)
		{
			if($li->user1 == $user_id)
				$li->user = User::GetById($li->user2);
			else
				$li->user = User::GetById($li->user1);
		}
		return $list;
	}
}