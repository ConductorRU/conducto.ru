<?php
namespace app\model;
use core\dc\Model;
class AttributeType extends Model
{
	public static function Create($id, $code, $isMulti = 0)
	{
		$t = new AttributeType;
		$t->id = $id;
		$t->code = $code;
		$t->multi = $isMulti;
		if($t->save())
			return $t;
		return null;
	}
	public static function GetIdByCode($code)
	{
		return (int)static::FindOne('id', 'WHERE code="' . $code . '"');
	}
}