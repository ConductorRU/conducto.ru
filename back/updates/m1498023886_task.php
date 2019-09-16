<?php
namespace back\updates;
use core\dc\DC;
class m1498023886_task extends UpdateBase
{
	public function up()
	{
		$db = DC::$app->db;
		$db->CreateTable('task',
		[
			'id' => 'int(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY',
			'name' => 'VARCHAR(255) NOT NULL',
			'creator' => 'int(11) UNSIGNED DEFAULT NULL',
			'description' => 'VARCHAR(65535)',
			'created_at' => 'DATETIME NOT NULL',
			'finished_at' => 'DATETIME NOT NULL',
			'status' => 'tinyint UNSIGNED NOT NULL DEFAULT 1'
		]);
		$db->AddForeignKey('task_user', 'task', 'creator', 'user', 'id', 'SET NULL', 'CASCADE');
		$db->AddIndex('task_user_index', 'task', 'creator');
		
		$db->CreateTable('subtask',
		[
			'id' => 'int(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY',
			'task_id' => 'int(11) UNSIGNED NOT NULL',
			'parent_id' => 'int(11) UNSIGNED DEFAULT NULL',
			'name' => 'VARCHAR(255) NOT NULL',
			'description' => 'VARCHAR(65535)',
			'percent' => 'tinyint UNSIGNED NOT NULL DEFAULT 0',
			'weight' => 'tinyint UNSIGNED NOT NULL DEFAULT 5',
			'created_at' => 'DATETIME NOT NULL',
			'finished_at' => 'DATETIME',
			'status' => 'tinyint UNSIGNED NOT NULL DEFAULT 1',
		]);
		$db->AddForeignKey('subtask_task', 'subtask', 'task_id', 'task', 'id', 'CASCADE', 'CASCADE');
		$db->AddForeignKey('subtask_parent', 'subtask', 'parent_id', 'subtask', 'id', 'SET NULL', 'CASCADE');
		$db->AddIndex('subtask_task_index', 'subtask', 'task_id');
		$db->AddIndex('subtask_parent_index', 'subtask', ['task_id', 'parent_id']);
	}
	public function down()
	{
		$db = DC::$app->db;
		$db->DropTable('subtask');
		$db->DropTable('task');
	}
}
