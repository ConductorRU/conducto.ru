<?php
namespace app\model;
use core\dc\Model;
class Anonym extends Model
{
	public static function Get($isCreate = true)
	{
		if(session_id() == '')
			return null;
		$url = $_SERVER['REQUEST_URI'];
		$ip = $_SERVER['REMOTE_ADDR'];
		$agent = $_SERVER['HTTP_USER_AGENT'];
		$date = date('Y-m-d H:i:s');
		$anonym = Anonym::FindWhere('id="' . session_id() . '"');
		if($anonym)
		{
			$anonym->url = $url;
			$anonym->ip = inet_pton($ip);
			$anonym->user_agent = $agent;
			$anonym->visited_at = $date;
			++$anonym->count;
			$anonym->update();
			return $anonym;
		}
		if($isCreate)
		{
			$anonym = new Anonym;
			$anonym->id = session_id();
			$anonym->url = $url;
			$anonym->ip = inet_pton($ip);
			$anonym->user_agent = $agent;
			$anonym->created_at = $anonym->visited_at = $date;
			$anonym->count = 1;
			if($anonym->save())
				return $anonym;
		}
		return null;
	}
}