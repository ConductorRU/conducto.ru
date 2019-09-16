<?php
namespace app\model;
use core\dc\Model;
class Im extends Model
{
	public function GetPosts($start = 0, $page = 0, $limit = 20, $isDesc = false)
	{
		$desc = '';
		if($isDesc)
			$desc = ' ORDER BY id DESC';
		$t = '';
		$l = '';
		if($start)
			$t .= 'id > ' . $start . ' AND ';
		if($l)
			$l .= $page . ', ';
		$all = Post::SelectAll('*', 'WHERE ' . $t . ' wall_id = ' . $this->wall_id . $desc . ' LIMIT ' . $l . $limit);
		if($isDesc)
			return array_reverse($all);
		return $all;
	}
	public function GetPostCount()
	{
		return (int)Post::FindOne('COUNT(*)', 'WHERE wall_id = ' . $this->wall_id);
	}
	public function GetLast()
	{
		return (int)Post::FindOne('id', 'WHERE wall_id = ' . $this->wall_id . ' ORDER BY id DESC');
	}
	public function AddPost($text, $userId = null, $anonymId = null)
	{
		$post = new Post;
		$post->wall_id = $this->wall_id;
		$post->text = $text;
		$post->status = 1;
		$post->creator = $userId;
		$post->anonym_id = $anonymId;
		$post->created_at = date('Y.m.d H:i:s');
		if($post->Save())
			return $post;
		return null;
	}
}