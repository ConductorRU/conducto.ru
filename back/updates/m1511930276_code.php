<?php
namespace back\updates;
use core\dc\DC;
class m1511930276_code extends UpdateBase
{
	public function up()
	{
		$db = DC::$app->db;
		$db->CreateTable('code',
		[
			'id' => 'int(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY',
			'name' => 'VARCHAR(255) NOT NULL',
			'type' => 'tinyint UNSIGNED NOT NULL DEFAULT 1',
			'creator' => 'int(11) UNSIGNED DEFAULT NULL',
			'number' => 'int(11) UNSIGNED DEFAULT 1',
			'content' => 'MEDIUMTEXT DEFAULT NULL',
		]);
	}
	public function down()
	{
		$db = DC::$app->db;
		$db->DropTable('code');
	}
}