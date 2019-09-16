<?php
namespace app\model;
use core\dc\Model;
class Wall extends Model
{
	public static function CreateId()
	{
		$wall = new Wall;
		$wall->save();
		if($wall->id)
			return $wall->id;
		return 0;
	}
}