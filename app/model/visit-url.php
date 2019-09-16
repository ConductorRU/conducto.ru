<?php
namespace app\model;
use core\dc\Model;
class VisitUrl extends Model
{
	public static function LoadByUrl($url)
	{
		return VisitUrl::FindWhere('url="' . $url . '"');
	}
}