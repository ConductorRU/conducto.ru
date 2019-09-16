<?php
namespace app\model;
use core\dc\Model;
use core\dc\DC;
class Subscribe extends Model
{
	public static function Add($user_id, $entity_id, $entity_type)
	{
		$sub = Subscribe::FindWhere('user_id=' . $user_id . ' AND entity_id=' . $entity_id . ' AND entity_type=' . $entity_type);
		if($sub)
		{
			$sub->updated_at = date('Y-m-d H:i:s');
			$sub->status = 1;
			return $sub->update();
		}
		$sub = new Subscribe;
		$sub->user_id = $user_id;
		$sub->entity_id = $entity_id;
		$sub->entity_type = $entity_type;
		$sub->created_at = $sub->updated_at = date('Y-m-d H:i:s');
		$sub->status = 1;
		return $sub->save();
	}
	public static function Remove($user_id, $entity_id, $entity_type)
	{
		$sub = Subscribe::FindWhere('user_id=' . $user_id . ' AND entity_id=' . $entity_id . ' AND entity_type=' . $entity_type);
		if($sub)
		{
			$sub->status = 0;
			return $sub->update();
		}
		return true;
	}
	public static function GetList($user_id, $entity_type, $start = 0, $count = 20, $order = 'updated_at')
	{
		return Subscribe::SelectAll('*', 'WHERE user_id=' . $user_id . ' AND entity_type=' . $entity_type . ' ORDER BY ' . $order . ' LIMIT ' . $start . ' , ' . $count);
	}
}