<?php
namespace back\updates;
use core\dc\DC;
class m1511692673_article extends UpdateBase
{
	public function up()
	{
		$db = DC::$app->db;
		$db->CreateTable('article',
		[
			'id' => 'int(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY',
			'entity_id' => 'bigint(20) UNSIGNED NOT NULL',
			'name' => 'VARCHAR(255) NOT NULL',
			'description' => 'VARCHAR(10000) DEFAULT NULL',
			'creator' => 'int(11) UNSIGNED DEFAULT NULL',
			'content' => 'MEDIUMTEXT DEFAULT NULL',
			'status' => 'tinyint UNSIGNED NOT NULL DEFAULT 1',
			'created_at' => 'DATETIME NOT NULL',
			'updated_at' => 'DATETIME NOT NULL',
		]);
		$db->AddForeignKey('article_entity', 'article', 'entity_id', 'entity', 'id', 'CASCADE', 'CASCADE');
		$db->AddForeignKey('article_user', 'article', 'creator', 'user', 'id', 'SET NULL', 'CASCADE');
	}
	public function down()
	{
		$db = DC::$app->db;
		$db->DropTable('article');
	}
}
