<?php
namespace back\updates;
use core\dc\DC;
use back\model\Update;
class UpdateBase
{
	public static function getFiles()
	{
		$db = DC::$app->db;
		$entries = scandir(__DIR__);
		$files = [];
		$isTable = $db->IsTable('update');
		foreach($entries as $entry)
			if($entry != '.' && $entry != '..' && $entry != 'update-base.php')
			{
				$name = str_replace('.php', '', $entry);
				$m = null;
				if($isTable)
					$m = Update::FindWhere('name ="' . $name . '"');
				if($m)
					$files[$name] = 0;
				else
					$files[$name] = 1;
			}
		return $files;
	}
	public static function Create($name)
	{
		sleep(2);
		$path = __DIR__;
		$fname = 'm' . time() . '_' . $name;
		$nm = $path . '/' . $fname . '.php';
		$f = fopen($nm, 'w');
		if($f === FALSE)
			return 0;
		fwrite($f, '<?php' . "\n");
		fwrite($f, 'namespace back\updates;' . "\n");
		fwrite($f, 'use core\dc\DC;' . "\n");
		fwrite($f, 'class ' . $fname . ' extends UpdateBase' . "\n");
		fwrite($f, '{' . "\n");
		fwrite($f, "\t" . 'public function up()' . "\n");
		fwrite($f, "\t" . '{' . "\n");
		fwrite($f, "\t\t" . '' . "\n");
		fwrite($f, "\t" . '}' . "\n");
		fwrite($f, "\t" . 'public function down()' . "\n");
		fwrite($f, "\t" . '{' . "\n");
		fwrite($f, "\t\t" . 'return false;' . "\n");
		fwrite($f, "\t" . '}' . "\n");
		fwrite($f, '}' . "\n");
		fclose($f);
		//chgrp($nm, 'client1');
		//chown($nm, 'web8');
		chmod($nm, 0777);
		return 1;
	}
	public static function Delete($name)
	{
		$file = __DIR__ . '/' . $name . '.php';
		if(!file_exists($file))
			return 0;
		unlink($file);
		return 1;
	}
	public static function UpdateDown($name)
	{
		$m = Update::FindWhere('name ="' . $name . '"');
		if($m)
		{
			$t = '\\back\\updates\\' . $name;
			$cur = new $t();
			$cur->down();
			$m->Delete();
			return 1;
		}
		return 0;
	}
	public function up()
	{
		$db = DC::$app->db;
		$db->CreateTable('update',
		[
			'name' => 'VARCHAR(255) NOT NULL PRIMARY KEY',
			'created_at' => 'DATETIME'
		]);
		$db->CreateTable('entity',
		[
			'id' => 'bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY',
		]);
		$db->createTable('user',
		[
			'id' => 'int(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY',
			'entity_id' => 'bigint(20) UNSIGNED NOT NULL',
			'login' => 'varchar(255) NOT NULL UNIQUE',
			'auth_key' => 'varchar(32) NOT NULL',
			'password_hash' => 'varchar(255) NOT NULL',
			'password_reset_token' => 'varchar(255) UNIQUE',
			'email' => 'varchar(255) UNIQUE',
			'status' => 'tinyint UNSIGNED NOT NULL DEFAULT 1',
			'created_at' => 'DATETIME NOT NULL',
			'updated_at' => 'DATETIME',
			'visited_at' => 'DATETIME',
		]);
		$db->AddForeignKey('user_entity', 'user', 'entity_id', 'entity', 'id', 'CASCADE', 'CASCADE');
		
		$user = new \app\model\User;
		$user->entity_id = \app\model\Entity::CreateId();
		$user->login = 'admin';
		$user->email = 'draaks@yandex.ru';
		$user->status = 1;
		$user->setPassword('123456');
		$user->generateAuthKey();
		$user->created_at = date('Y-m-d H:i:s');
		$user->updated_at = $user->created_at;
		$user->save();
	}
	public function down()
	{
		$db = DC::$app->db;
		$isMig = $db->IsTable('update');
		if($isMig)
		{
			$db->DropTable('user');
			$db->DropTable('update');
		}
	}
	public function exe($down = 0)
	{
		$isMig = DC::$app->db->IsTable('update');
		if(!$isMig)
			$this->up();
		if($down == -1)
			return 0;
		$cnt = 0;
		if($down == 0)
		{
			$files = self::getFiles();
			foreach($files as $k => $v)
			{
				if($v)
				{
					$t = '\\back\\updates\\' . $k;
					$cur = new $t();
					$cur->up();
					$m = new Update;
					$m->name = $k;
					$m->created_at = date('Y-m-d H:i:s');
					$m->Save();
					++$cnt;
				}
			}
		}
		else
		{
			$all = Update::find()->orderBy('version desc')->limit($down)->all();
			foreach($all as $al)
			{
				$t = '\\back\\updates\\' . $al->version;
				$v = new $t();
				$v->down();
				$al->delete();
				++$cnt;
			}
		}
		return $cnt;
	}
}