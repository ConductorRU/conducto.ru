<?php
namespace back\updates;
use core\dc\DC;
use app\model\User;
class m1554906475_post_import extends UpdateBase
{
	public function up()
	{
		$db = DC::$app->db;
		$oldb = DC::$app->oldb;
		$users = $oldb->findAll('SELECT * FROM users');
		foreach($users as $v)
		{
			$user = new User;
			$user->id = $v['id'];
			$user->entity_id = \app\model\Entity::CreateId();
			$user->login = $v['login'];
			$user->email = $v['email'];
			$user->status = 1;
			$user->password_hash = $v['password'];
			$user->generateAuthKey();
			$user->created_at = date('Y-m-d H:i:s', $v['time_reg']);
			$user->updated_at = date('Y-m-d H:i:s', $v['time']);
			$user->save();
		}
	}
	public function down()
	{
		$db = DC::$app->db;
		$db->ClearTable('user');
	}
}
