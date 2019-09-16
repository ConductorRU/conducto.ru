<?php
namespace back\updates;
use core\dc\DC;
class m1489727193_visit extends UpdateBase
{
	public function up()
	{
		$db = DC::$app->db;
		$db->CreateTable('visit_url',
		[
			'id' => 'bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY',
			'url' => 'VARCHAR(255) NOT NULL UNIQUE',
			'count' => 'int(11) UNSIGNED DEFAULT 0',
		]);
		$db->CreateTable('visit',
		[
			'id' => 'bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY',
			'url_id' => 'bigint(20) UNSIGNED NOT NULL',
			'user_id' => 'int(11) UNSIGNED DEFAULT NULL',
			'ip' => 'BINARY(16) DEFAULT NULL',
			'user_agent' => 'VARCHAR(255) DEFAULT NULL',
			'visited_at' => 'DATETIME NOT NULL',
		]);
		$db->AddForeignKey('visit_user_fk', 'visit', 'user_id', 'user', 'id', 'CASCADE', 'CASCADE');
		$db->AddForeignKey('visit_url_fk', 'visit', 'url_id', 'visit_url', 'id', 'CASCADE', 'CASCADE');
	}
	public function down()
	{
		$db = DC::$app->db;
		$db->DropTable('visit');
		$db->DropTable('visit_url');
	}
}
