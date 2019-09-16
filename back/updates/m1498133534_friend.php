<?php
namespace back\updates;
use core\dc\DC;
class m1498133534_friend extends UpdateBase
{
	public function up()
	{
		$db = DC::$app->db;
		$db->CreateTable('friend',
		[
			'sender' => 'int(11) UNSIGNED NOT NULL',
			'receiver' => 'int(11) UNSIGNED NOT NULL',
			'status' => 'tinyint UNSIGNED NOT NULL DEFAULT 1',
			'created_at' => 'DATETIME NOT NULL'
		]);
		$db->AddForeignKey('friend_sender', 'friend', 'sender', 'user', 'id', 'CASCADE', 'CASCADE');
		$db->AddForeignKey('friend_receiver', 'friend', 'receiver', 'user', 'id', 'CASCADE', 'CASCADE');
		$db->AddPrimaryKey('friend_pk', 'friend', ['sender', 'receiver']);
	}
	public function down()
	{
		$db = DC::$app->db;
		$db->DropTable('friend');
	}
}
