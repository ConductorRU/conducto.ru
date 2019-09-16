<?php
namespace app\model;
use core\dc\Model;
class Visit extends Model
{
	public static function AddVisit()
	{
		$url = $_SERVER['REQUEST_URI'];
		$ip = $_SERVER['REMOTE_ADDR'];
		$agent = $_SERVER['HTTP_USER_AGENT'];
		$time = date('Y-m-d H:i:s');
		$vUrl = VisitUrl::LoadByUrl($url);
		if(!$vUrl)
		{
			$vUrl = new VisitUrl;
			$vUrl->url = $url;
			$vUrl->count = 1;
			$vUrl->save();
		}
		else
		{
			++$vUrl->count;
			$vUrl->update();
		}
		if($vUrl->id)
		{
			$visit = new Visit;
			$visit->url_id = $vUrl->id;
			$visit->ip = inet_pton($ip);
			$visit->user_agent = $agent;
			$visit->visited_at = $time;
			$visit->save();
		}
	}
}