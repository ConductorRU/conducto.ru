<?php
namespace app\model;
use core\dc\Model;
use core\dc\DC;
class Entity extends Model
{
	public static function CreateId()
	{
		$en = new Entity;
		$en->save();
		if($en->id)
			return $en->id;
		return 0;
	}
}