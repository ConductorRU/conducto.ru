<?php
namespace back\updates;
use core\dc\DC;
class m1512535885_album extends UpdateBase
{
	public function up()
	{
		$db = DC::$app->db;
		$db->CreateTable('image',
		[
			'id' => 'bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY',
			'parent_id' => 'bigint(20) UNSIGNED NOT NULL',
			'code' => 'VARCHAR(1) NOT NULL',
			'host' => 'VARCHAR(255) NOT NULL',
			'path' => 'VARCHAR(255) NOT NULL',
			'width' => 'SMALLINT UNSIGNED DEFAULT NULL',
			'height' => 'SMALLINT UNSIGNED DEFAULT NULL',
		]);
		$db->AddForeignKey('image_parent', 'image', 'parent_id', 'entity', 'id', 'CASCADE', 'CASCADE');
		
		$db->CreateTable('album',
		[
			'id' => 'int(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY',
			'entity_id' => 'bigint(20) UNSIGNED NOT NULL',
			'name' => 'VARCHAR(255) NOT NULL',
			'description' => 'VARCHAR(1000) NOT NULL',
			'creator' => 'int(11) UNSIGNED NOT NULL',
			'status' => 'tinyint UNSIGNED NOT NULL DEFAULT 1',
			'created_at' => 'DATETIME NOT NULL',
			'updated_at' => 'DATETIME NOT NULL',
		]);
		$db->AddForeignKey('album_entity', 'album', 'entity_id', 'entity', 'id', 'CASCADE', 'CASCADE');
		$db->AddForeignKey('album_user', 'album', 'creator', 'user', 'id', 'CASCADE', 'CASCADE');
		
		$db->CreateTable('photo',
		[
			'id' => 'int(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY',
			'entity_id' => 'bigint(20) UNSIGNED NOT NULL',
			'parent_id' => 'bigint(20) UNSIGNED NOT NULL',
			'creator' => 'int(11) UNSIGNED DEFAULT NULL',
			'status' => 'tinyint UNSIGNED NOT NULL DEFAULT 1',
			'created_at' => 'DATETIME NOT NULL',
		]);
		$db->AddForeignKey('photo_entity', 'photo', 'entity_id', 'entity', 'id', 'CASCADE', 'CASCADE');
		$db->AddForeignKey('photo_parent', 'photo', 'parent_id', 'entity', 'id', 'CASCADE', 'CASCADE');
		$db->AddForeignKey('photo_user', 'photo', 'creator', 'user', 'id', 'SET NULL', 'CASCADE');
	}
	public function down()
	{
		$db = DC::$app->db;
		$db->DropTable('photo');
		$db->DropTable('album');
		$db->DropTable('image');
	}
}
