<?php
namespace app\model;
use core\dc\Model;
use core\dc\DC;
class Attribute extends Model
{
	public static function Create($id, $name, $type)
	{
		$t = new Attribute;
		$t->id = $id;
		$t->type = $type;
		$t->name = $name;
		if($t->save())
			return $t;
		return null;
	}
	public static function LoadById($id)
	{
		return Attribute::FindWhere('id=' . $id);
	}
	public static function SetValue($entity_type, $entity_id, $attribute_id, $value)
	{
		$code = static::FindOne('code', 'LEFT JOIN attribute_type ON attribute.type = attribute_type.id WHERE attribute.id=' . $attribute_id);
		if($code)
		{
			$db = DC::$app->db;
			$at = 'attribute_' . $code;
			if($db->find('SELECT value FROM ' . $at . ' WHERE entity_type=' . $entity_type . ' AND entity_id=' . $entity_id . ' AND attribute_id=' . $attribute_id))
				$db->query('UPDATE ' . $at . ' SET value="' . $db->e($value) . '" WHERE entity_type=' . $entity_type . ' AND entity_id=' . $entity_id . ' AND attribute_id=' . $attribute_id);
			else
				$db->query('INSERT INTO ' . $at . ' VALUES (' . $entity_type . ', ' . $entity_id . ', ' . $attribute_id . ', "' . $db->e($value) . '"');
		}
	}
	public static function GetValue($entity_type, $entity_id, $attribute_id)
	{
		$code = static::FindOne('code', 'LEFT JOIN attribute_type ON attribute.type = attribute_type.id WHERE attribute.id=' . $attribute_id);
		return DC::$app->db->findOne('SELECT value FROM attribute_' . $code . ' WHERE entity_type=' . $entity_type . ' AND entity_id=' . $entity_id . ' AND attribute_id=' . $attribute_id);
	}
}