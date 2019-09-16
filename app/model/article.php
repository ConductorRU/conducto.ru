<?php
namespace app\model;
use core\dc\Model;
class Article extends Model
{
	public function IsVisible()
	{
		return !($this->status == 2);
	}
	public static function LoadById($id)
	{
		return Article::FindWhere('id=' . $id);
	}
	public static function MaxId()
	{
		return User::FindOne('MAX(id)');
	}
	public function GetUrl()
	{
		return '/article' . $this->id;
	}
	public static function GetList($user_id, $start = 0, $count = 20)
	{
		if($user_id)
			$list = Article::SelectAll('*', 'WHERE creator=' . $user_id . ' AND status != 0');
		else
			$list = Article::SelectAll('*', 'WHERE status = 1');
		return $list;
	}
	public function GetFormatContent($isEdit = 0)
	{
		$c = $this->content;
		if(preg_match_all('/\[attach(.*?)\]/siu', $c, $ms, PREG_SET_ORDER))
		{
			foreach($ms as $m)
			{
				$props = explode(' ', trim($m[1]));
				$pr = [];
				foreach($props as $prop)
				{
					$p = trim($prop);
					if($p != '')
					{
						$ex = explode('=', $p);
						if(count($ex) == 2)
							$pr[$ex[0]] = trim($ex[1], '"\'');
					}
				}
				if(isset($pr['data-type']))
				{	
					if($pr['data-type'] == 'code' && isset($pr['data-value']))
					{
						$code = Code::LoadById($pr['data-value']);
						if($code)
							$c = str_replace($m[0], $code->GetFormatContent($isEdit), $c);
					}
				}
			}
		}
		return $c;
	}
}