<?php
namespace app\model\helper;
use app\model\User;
use app\model\Chat;
use app\model\Task;
use app\model\Article;
use core\dc\DC;
class Search
{
	public static function SearchUsers($q, $start = 0, $count = 20, $max_id = 0)
	{
		$t = $max_id ? 'id<=' . $max_id . ' AND ' : '';
		return User::SelectAll('*', 'WHERE ' . $t . 'login LIKE "%' . DC::$app->db->e($q) . '%" LIMIT ' . $start . ', ' . $count);
	}
	public static function SearchChats($q, $start = 0, $count = 20, $max_id = 0)
	{
		$t = $max_id ? 'id<=' . $max_id . ' AND ' : '';
		return Chat::SelectAll('*', 'WHERE ' . $t . 'name LIKE "%' . DC::$app->db->e($q) . '%" LIMIT ' . $start . ', ' . $count);
	}
	public static function SearchTasks($q, $start = 0, $count = 20, $max_id = 0)
	{
		$t = $max_id ? 'id<=' . $max_id . ' AND ' : '';
		return Task::SelectAll('*', 'WHERE ' . $t . 'name LIKE "%' . DC::$app->db->e($q) . '%" LIMIT ' . $start . ', ' . $count);
	}
	public static function SearchArticles($q, $start = 0, $count = 20, $max_id = 0)
	{
		$t = $max_id ? 'id<=' . $max_id . ' AND ' : '';
		if(DC::$app->user->id)
			$t .= '(status = 1 OR (status = 2 AND creator=' . DC::$app->user->id . ')) AND ';
		else
			$t .= 'status = 1 AND ';
		return Article::SelectAll('*', 'WHERE ' . $t . 'name LIKE "%' . DC::$app->db->e($q) . '%" LIMIT ' . $start . ', ' . $count);
	}
}