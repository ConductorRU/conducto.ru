<?php
namespace back\updates;
use core\dc\DC;
class m1489552418_wall extends UpdateBase
{
	public function up()
	{
		$db = DC::$app->db;
		$db->CreateTable('wall',
		[
			'id' => 'bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY',
		]);
		$db->CreateTable('post',
		[
			'id' => 'bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY',
			'wall_id' => 'bigint(20) UNSIGNED NOT NULL',
			'text' => 'VARCHAR(65535) NOT NULL',
			'creator' => 'int(11) UNSIGNED DEFAULT NULL',
			'status' => 'tinyint UNSIGNED NOT NULL DEFAULT 1',
			'created_at' => 'DATETIME NOT NULL'
		]);
		$db->AddForeignKey('post_wall_fk', 'post', 'wall_id', 'wall', 'id', 'CASCADE', 'CASCADE');
		$db->AddForeignKey('post_user_fk', 'post', 'creator', 'user', 'id', 'SET NULL', 'CASCADE');
		$db->AddColumn('chat', 'wall_id', 'bigint(20) UNSIGNED NOT NULL', 'id');
		$db->AddForeignKey('chat_wall_fk', 'chat', 'wall_id', 'wall', 'id', 'CASCADE', 'CASCADE');
		
		\app\model\Chat::Create('Первый чат', 1);
	}
	public function down()
	{
		$db = DC::$app->db;
		$db->ClearTable('chat');
		$db->DropForeignKey('chat', 'chat_wall_fk');
		$db->DropColumn('chat', 'wall_id');
		$db->DropTable('post');
		$db->DropTable('wall');
	}
}
