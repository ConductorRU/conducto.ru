<?php
namespace back\updates;
use core\dc\DC;
class m1498104766_log extends UpdateBase
{
	public function up()
	{
		$db = DC::$app->db;
		$db->CreateTable('logger',
		[
			'name' => 'VARCHAR(255) NOT NULL PRIMARY KEY',
			'value' => 'VARCHAR(65535)',
		]);
	}
	public function down()
	{
		$db = DC::$app->db;
		$db->DropTable('logger');
	}
}
