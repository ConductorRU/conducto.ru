<?php
namespace back\updates;
use core\dc\DC;
class m1489475811_chat extends UpdateBase
{
	public function up()
	{
		$db = DC::$app->db;
		$db->CreateTable('chat',
		[
			'id' => 'int(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY',
			'entity_id' => 'bigint(20) UNSIGNED NOT NULL',
			'name' => 'VARCHAR(255) NOT NULL',
			'creator' => 'int(11) UNSIGNED DEFAULT NULL',
			'status' => 'tinyint UNSIGNED NOT NULL DEFAULT 1',
			'created_at' => 'DATETIME NOT NULL',
			'updated_at' => 'DATETIME NOT NULL',
		]);
		$db->AddForeignKey('chat_entity', 'chat', 'entity_id', 'entity', 'id', 'CASCADE', 'CASCADE');
		$db->AddForeignKey('chat_user', 'chat', 'creator', 'user', 'id', 'SET NULL', 'CASCADE');
	}
	public function down()
	{
		$db = DC::$app->db;
		$db->DropTable('chat');
	}
}
