<?php
namespace app\model;
use core\dc\Model;
class Task extends Model
{
	public static function LoadById($id)
	{
		return Task::FindWhere('id=' . $id);
	}
	public function GetUrl()
	{
		return '/task' . $this->id;
	}
}