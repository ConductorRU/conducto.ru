<?php
namespace app\model;
use core\dc\Model;
class Album extends Model
{
	public static function LoadById($id)
	{
		return static::FindWhere('id=' . $id);
	}
	public static function MaxId()
	{
		return User::FindOne('MAX(id)');
	}
	public function GetUrl()
	{
		return '/album' . $this->id;
	}
	public static function GetList($user_id, $start = 0, $count = 20)
	{
		if($user_id)
			$list = Article::SelectAll('*', 'WHERE creator=' . $user_id . ' AND status != 0');
		else
			$list = Article::SelectAll('*', 'WHERE status = 1');
		return $list;
	}
}