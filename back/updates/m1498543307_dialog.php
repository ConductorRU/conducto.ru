<?php
namespace back\updates;
use core\dc\DC;
class m1498543307_dialog extends UpdateBase
{
	public function up()
	{
		$db = DC::$app->db;
		$db->CreateTable('dialog',
		[
			'user1' => 'int(11) UNSIGNED NOT NULL',
			'user2' => 'int(11) UNSIGNED NOT NULL',
			'start1' => 'bigint(20) UNSIGNED NOT NULL DEFAULT 0',
			'start2' => 'bigint(20) UNSIGNED NOT NULL DEFAULT 0',
			'wall_id' => 'bigint(20) UNSIGNED NOT NULL',
			'created_at' => 'DATETIME NOT NULL',
			'updated_at' => 'DATETIME NOT NULL',
		]);
		$db->AddForeignKey('dialog_user1', 'dialog', 'user1', 'user', 'id', 'CASCADE', 'CASCADE');
		$db->AddForeignKey('dialog_user2', 'dialog', 'user2', 'user', 'id', 'CASCADE', 'CASCADE');
		$db->AddForeignKey('dialog_wall', 'dialog', 'wall_id', 'wall', 'id', 'CASCADE', 'CASCADE');
		$db->AddPrimaryKey('dialog_pk', 'dialog', ['user1', 'user2']);
	}
	public function down()
	{
		$db = DC::$app->db;
		$db->DropTable('dialog');
	}
}
