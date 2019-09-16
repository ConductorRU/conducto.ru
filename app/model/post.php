<?php
namespace app\model;
use core\dc\Model;
class Post extends Model
{
	public static function LoadById($id)
	{
		return Post::FindWhere('id=' . $id);
	}
	public function GetCreatedAt()
	{
		$t = $this->created_at;
		$ex = explode(' ', $t);
		if(count($ex) == 2)
		{
			$t = '';
			if(date('Y-m-d') == $ex[0])
				$t .= '<div>сегодня</div>';
			else if(date('Y-m-d', time() - 60*60*24) == $ex[0])
				$t .= '<div>вчера</div>';
			else
				$t .= '<div>' . date('d.m.Y', strtotime($ex[0])) . '</div>';
			$t .= '<div>' . date('H:i', strtotime($ex[1])) . '</div>';
		}
		return '<div title="' . date('d.m.Y', strtotime($this->created_at)) . ' в ' . date('H:i:s', strtotime($this->created_at)) . '">' . $t . '</div>';
	}
	public function GetText()
	{
		$t = $this->text;
		return $t;
	}
	public function GetUser()
	{
		if(!$this->creator)
			return null;
		return User::GetById($this->creator);
	}
}