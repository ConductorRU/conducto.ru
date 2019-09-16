<?php
namespace back\updates;
use core\dc\DC;
class m1489742829_anonym extends UpdateBase
{
	public function up()
	{
		$db = DC::$app->db;
		$db->CreateTable('anonym',
		[
			'id' => 'varchar(128) NOT NULL PRIMARY KEY',
			'name' => 'varchar(255) DEFAULT NULL',
			'url' => 'varchar(255) DEFAULT NULL',
			'ip' => 'BINARY(16) DEFAULT NULL',
			'user_agent' => 'VARCHAR(255) DEFAULT NULL',
			'created_at' => 'DATETIME NOT NULL',
			'visited_at' => 'DATETIME NOT NULL',
			'count' => 'int(11) UNSIGNED DEFAULT 1',
		]);
		$db->AddColumn('post', 'anonym_id', 'varchar(128) DEFAULT NULL', 'status');
		$db->AddForeignKey('post_anonym_fk', 'post', 'anonym_id', 'anonym', 'id', 'SET NULL', 'CASCADE');
	}
	public function down()
	{
		$db = DC::$app->db;
		$db->DropForeignKey('post', 'post_anonym_fk');
		$db->DropColumn('post', 'anonym_id');
		$db->DropTable('anonym');
	}
}
