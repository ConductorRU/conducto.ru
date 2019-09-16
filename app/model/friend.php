<?php
namespace app\model;
use core\dc\Model;
use core\dc\DC;
class Friend extends Model
{
	const STATUS_CANCEL = 0;
	const STATUS_MUTUAL = 1;
	const STATUS_SUBSCRIBE = 2;
	public static function Get($sender_id, $receiver_id)
	{
		return Friend::FindWhere('sender=' . $sender_id . ' AND receiver=' . $receiver_id);
	}
	public static function AddFriend($sender_id, $receiver_id)
	{
		if(!$sender_id || !$receiver_id)
			return null;
		$f = Friend::FindWhere('sender=' . $sender_id . ' AND receiver=' . $receiver_id);
		$r = Friend::FindWhere('sender=' . $receiver_id . ' AND receiver=' . $sender_id);
		if(!$f)
		{
			$f = new Friend;
			$f->sender = $sender_id;
			$f->receiver = $receiver_id;
			$f->created_at = date('Y-m-d H:i:s');
		}
		if($f->status != Friend::STATUS_CANCEL)
			return $f;
		$f->status = Friend::STATUS_SUBSCRIBE;
		if($r && $r->status == Friend::STATUS_SUBSCRIBE)
			$f->status = $r->status = Friend::STATUS_MUTUAL;
		if($f->id)
			$f->Update();
		else if(!$f->Save())
			return null;
		if($r)
			$r->Update();
		return $f;
	}
	public static function RemoveFriend($sender_id, $receiver_id)
	{
		if(!$sender_id || !$receiver_id)
			return null;
		$f = Friend::FindWhere('sender=' . $sender_id . ' AND receiver=' . $receiver_id);
		$r = Friend::FindWhere('sender=' . $receiver_id . ' AND receiver=' . $sender_id);
		if($f)
		{
			$f->status = Friend::STATUS_CANCEL;
			$f->Update();
			if($r && $r->status == Friend::STATUS_MUTUAL)
			{
				$r->status == Friend::STATUS_SUBSCRIBE;
				$r->Update();
			}
		}
		return null;
	}
	public static function GetCount($user_id)
	{
		return (int)Friend::FindOne('COUNT(*)', 'WHERE sender=' . $user_id . ' AND status !=0');
	}
	public static function GetUsers($user_id, $count = 6, $sort = 0)
	{
		return User::FindAll('SELECT * FROM user RIGHT JOIN friend ON receiver = user.id WHERE sender=' . $user_id . ' AND friend.status!=0');
	}
	public static function GetUrl($user_id)
	{
		return '/friends' . $user_id;
	}
}