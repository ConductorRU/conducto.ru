<?php
namespace back\updates;
use core\dc\DC;
class m1500010556_subscribe extends UpdateBase
{
	public function up()
	{
		$db = DC::$app->db;
		$db->CreateTable('subscribe',
		[
			'user_id' => 'int(11) UNSIGNED NOT NULL',
			'entity_id' => 'bigint(20) UNSIGNED NOT NULL',
			'entity_type' => 'TINYINT UNSIGNED NOT NULL',
			'created_at' => 'DATETIME NOT NULL',
			'updated_at' => 'DATETIME NOT NULL',
			'status' => 'tinyint UNSIGNED NOT NULL DEFAULT 1',
		]);
		$db->AddForeignKey('subscribe_user', 'subscribe', 'user_id', 'user', 'id', 'CASCADE', 'CASCADE');
		$db->AddForeignKey('subscribe_entity', 'subscribe', 'entity_id', 'entity', 'id', 'CASCADE', 'CASCADE');
		$db->AddForeignKey('subscribe_type', 'subscribe', 'entity_type', 'entity_type', 'id', 'CASCADE', 'CASCADE');
		$db->AddPrimaryKey('subscribe_pk', 'subscribe', ['user_id', 'entity_id', 'entity_type']);
		$db->AddIndex('subscribe_list', 'subscribe', ['user_id', 'entity_type']);
	}
	public function down()
	{
		$db = DC::$app->db;
		$db->DropTable('subscribe');
	}
}
