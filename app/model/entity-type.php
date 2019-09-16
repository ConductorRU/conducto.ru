<?php
namespace app\model;
use core\dc\Model;
use core\dc\DC;
class EntityType extends Model
{
	public static function Create($id, $name)
	{
		$t = new EntityType;
		$t->id = $id;
		$t->name = $name;
		if($t->save())
			return $t;
		return null;
	}
	public static function GetIdByName($name)
	{
		return (int)static::FindOne('id', 'WHERE name="' . DC::$app->db->e($name) . '"');
	}
}