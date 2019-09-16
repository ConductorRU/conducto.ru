<?php
namespace Core\DC;
class DBTable
{
	public $fields = [];
	public $incField = '';
}
class DB
{
	private $tableData = [];
	public $sql;
	public $cacheTable = [];
	public function __construct($localhost, $user, $password, $dbname)
	{
		$this->sql = new \mysqli($localhost, $user, $password, $dbname);
		$this->sql->set_charset('utf8');
	}
	public function SetTableToCache($tableName, $fields, $incField = '')
	{
		$f = new DBTable;
		$f->fields = $fields;
		$f->incField = $incField;
		$cacheTable[$tableName] = $f;
		return $f;
	}
	public function GetTableToCache($tableName)
	{
		return isset($cacheTable[$tableName]) ? $cacheTable[$tableName] : null;
	}
	public function e($t)
	{
		return $this->sql->real_escape_string($t);
	}
	public function query($q)
	{
		$y = $this->sql->query($q);
		if($y === FALSE)
		{
			echo $q . '<br>';
			print_r($this->sql->error_list);
			echo '<pre>';
			debug_print_backtrace();
			echo '</pre>';
			die();
		}
		return $y;
	}
	public function find($q)
	{
		return $this->query($q)->fetch_array(MYSQLI_ASSOC);
	}
	public function findOne($q)
	{
		return $this->query($q)->fetch_row()[0];
	}
	public function findAll($q)
	{
		return $this->query($q)->fetch_all(MYSQLI_BOTH);
	}
	public function __destruct()
	{
		$this->sql->close();
	}
	public function GetColumns($table)
	{
		if(isset($tableData[$table]))
			return $tableData[$table];
		$rows = $this->query('SHOW COLUMNS FROM `' . $table . '`')->fetch_all(MYSQLI_ASSOC);
		$tableData[$table] = $rows;
		return $rows;
	}
	public function IsTable($table)
	{
		if($res = $this->query('SHOW TABLES LIKE "' . $table . '"'))
			if($res->num_rows == 1)
				return 1;
		return 0;
	}
	private function SplitRows($cols)
	{
		$t = '';
		if(is_array($cols))
		{
			foreach($cols as $row)
			{
				if($t != '')
					$t .= ', ';
				$t .= '`' . $row . '`';
			}
			return $t;
		}
		return '`' . $cols . '`';
	}
	public function CreateTable($name, $cols)
	{
		$t = 'CREATE TABLE IF NOT EXISTS `' . $name . '` (';
		$c = '';
		foreach($cols as $key => $col)
		{
			if($c != '')
				$c .= ', ';
			$c .= '`' . $key . '` ' . $col;
		}
		$t .= $c . ') CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB;';
		return $this->query($t);
	}
	public function AddPrimaryKey($name, $table, $cols)
	{
		$t = $this->SplitRows($cols);
		return $this->query('ALTER TABLE `' . $table . '` ADD CONSTRAINT `' . $name . '` PRIMARY KEY (' . $t . ')');
	}
	public function DropPrimaryKey($table)
	{
		return $this->query('ALTER TABLE `' . $table . '` DROP PRIMARY KEY');
	}
	public function AddForeignKey($keyName, $table, $cols, $refTable, $refRows, $onDelete = '', $onUpdate = '')
	{
		$t1 = $this->SplitRows($cols);
		$t2 = $this->SplitRows($refRows);
		$t = '';
		if($onDelete)
			$t .= ' ON DELETE ' . $onDelete;
		if($onUpdate)
			$t .= ' ON UPDATE ' . $onUpdate;
		return $this->query('ALTER TABLE `' . $table . '` ADD CONSTRAINT `' . $keyName . '` FOREIGN KEY (' . $t1 . ') REFERENCES `' . $refTable . '`(' . $t2 . ')' . $t);
	}
	public function DropForeignKey($table, $keyName)
	{
		return $this->query('ALTER TABLE `' . $table . '` DROP FOREIGN KEY `' . $keyName . '`');
	}
	public function AddIndex($indexName, $table, $cols)
	{
		$t = $this->SplitRows($cols);
		return $this->query('CREATE INDEX `' . $indexName . '` ON `' . $table . '`(' . $t . ')');
	}
	public function AddUnique($indexName, $table, $cols)
	{
		$t = $this->SplitRows($cols);
		return $this->query('CREATE UNIQUE INDEX `' . $indexName . '` ON `' . $table . '`(' . $t . ')');
	}
	public function DropIndex($indexName, $table)
	{
		return $this->query('ALTER TABLE `' . $table . '` DROP INDEX `' . $indexName . '`');
	}
	public function DropTable($table)
	{
		return $this->query('DROP TABLE `' . $table . '`');
	}
	public function ClearTable($table)
	{
		return $this->query('TRUNCATE TABLE `' . $table . '`');
	}
	public function AddColumn($table, $name, $data, $after = '')
	{
		if($after && $after != 'FIRST')
			$after = ' AFTER `' . $after . '`';
		return $this->query('ALTER TABLE `' . $table . '` ADD COLUMN `' . $name . '` ' . $data . $after);
	}
	public function ChangeColumn($table, $col, $opts)
	{
		return $this->query('ALTER TABLE `' . $table . '` ALTER COLUMN `' . $col . '`' . $opts);
	}
	public function DropColumn($table, $col)
	{
		return $this->query('ALTER TABLE `' . $table . '` DROP COLUMN `' . $col . '`');
	}
}