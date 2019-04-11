<?php
namespace back\updates;
use core\dc\DC;
class m1554903352_post extends UpdateBase
{
	public function up()
	{
		$db = DC::$app->db;
		$db->CreateTable('post',
		[
			'id' => 'bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY',
			'user_name' => 'VARCHAR(32) DEFAULT NULL',
			'user_id' => 'int(11) UNSIGNED DEFAULT NULL',
			'message' => 'MEDIUMTEXT DEFAULT NULL',
			'created_at' => 'DATETIME NOT NULL',
			'status' => 'tinyint UNSIGNED NOT NULL DEFAULT 1',
		]);
		$db->AddForeignKey('post_user', 'post', 'user_id', 'user', 'id', 'SET NULL', 'CASCADE');
	}
	public function down()
	{
		$db = DC::$app->db;
		$db->DropTable('post');
	}
}
