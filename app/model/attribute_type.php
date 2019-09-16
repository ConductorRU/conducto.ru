<?php
namespace app\model;
use core\dc\Model;
class AttributeType extends Model
{
	public static function Create($code, $isMulti = 0)
	{
		$t = new AttributeType;
		$t->code = $code;
		$t->multi = $isMulti;
		$t->save();
		if($t->id)
			return $t;
		return null;
	}
}