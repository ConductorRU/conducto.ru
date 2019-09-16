<?php
namespace app\model;
use core\dc\Model;
use core\dc\DC;
class Logger extends Model
{
	public static function Set($name, $value)
	{
		$log = new Logger;
		$log->name = $name;
		$log->value = $value;
		if($log->Save())
			return 1;
		return 0;
	}
	public static function Get($name)
	{
		Logger::findWhere('name="' . DC::$app->db->e($name) . '"');
	}
}