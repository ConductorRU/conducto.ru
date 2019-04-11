<?php
namespace Core\DC;
class Model
{
	public $data = [];
	public $old = [];
	public $table = null;
	public $tableName = '';
	public function __construct()
	{
		$db = DC::$app->db;
		$class = self::GetTableName();
		if($db->IsTable($class))
			$this->table = $db->GetTableData($class);
		$this->tableName = $class;
	}
	public static function IsExist()
	{
		$class = self::GetTableName();
		if(DC::$app->db->IsTable($class))
			return 1;
		return 0;
	}
	public static function GetTableName()
	{
		$exp = explode('\\', get_called_class());
		$class = end($exp);
		$class = preg_replace('/([a-z])([A-Z])/', '$1_$2', $class);
		$class = mb_strtolower($class);
		return $class;
	}
	public function __get($name)
  {
		if(array_key_exists($name, $this->table->fields))
			return $this->table->fields[$name];
		if(array_key_exists($name, $this->data))
			return $this->data[$name];
		return null;
	}
	public function __set($name, $val)
  {
		if(array_key_exists($name, $this->table->fields))
			$this->table->fields[$name] = $val;
		else //if(array_key_exists($name, $this->data))
			$this->data[$name] = $val;
	}
	private function _set($cols, $dv = ',')
	{
		$db = DC::$app->db;
		$t = '';
		if(is_array($cols))
		{
			foreach($cols as $key => $row)
			{
				if($t != '')
					$t .= $dv . ' ';
				$t .= '`' . $key . '` = "' . $db->e($row) . '"';
			}
			return $t;
		}
		return '`' . $cols . '`';
	}
	private function _update($prim, $rows)
  {
		$db = DC::$app->db;
		$set = $this->_set($rows);
		$where = $this->_set($prim, 'AND');
		return $db->query('UPDATE `' . $this->tableName . '` SET ' . $set . ' WHERE ' . $where);
	}
	private function _insert($rows)
  {
		$db = DC::$app->db;
		$keys = array_keys($rows);
		$vals = array_values($rows);
		$k = '';
		$v = '';
		foreach($keys as $key)
		{
			if($k != '')
				$k .= ', ';
			$k .= '`' . $key . '`';
		}
		foreach($vals as $val)
		{
			if($v != '')
				$v .= ', ';
			$v .= '"' . $db->e($val) . '"';
		}
		$res = $db->query('INSERT INTO `' . $this->tableName . '` (' . $k . ') VALUES (' . $v . ')');
		$field = $this->table->incField;
		if($res && $field != '')
			$this->$field = $db->sql->insert_id;
		return $res;
	}
	private function _fields(&$prims, &$others)
  {
		$db = DC::$app->db;
		$cols = $db->GetColumns($this->tableName);
		foreach($cols as $col)
		{
			if($col['Key'] == 'PRI')
			{
				if($this->{$col['Field']} !== null)
					$prims[$col['Field']] = $this->{$col['Field']};
			}
			else if($this->{$col['Field']} !== null)
				$others[$col['Field']] = $this->{$col['Field']};
		}
	}
	private static function _select($fields)
  {
		$f = $fields;
		if(is_array($fields) && count($fields))
		{
			$f = '';
			foreach($fields as $field)
			{
				if($f != '')
					$f = ', ';
				$f .= '`' . $field . '`';
			}
		}
		return $f;
	}
	public static function Select($fields = '*', $where = '')
  {
		$db = DC::$app->db;
		return static::Find('SELECT ' . static::_select($fields) . ' FROM `' . static::GetTableName() . '` ' . $where);
	}
	public static function SelectAll($fields = '*', $where = '')
  {
		$db = DC::$app->db;
		return static::FindAll('SELECT ' . static::_select($fields) . ' FROM `' . static::GetTableName() . '` ' . $where);
	}
	public static function FindWhere($q = '')
  {
		if($q != '')
			$q = ' WHERE (' . $q . ')';
		return static::Find('SELECT * FROM `' . static::GetTableName() . '`' . $q);
	}
	public static function FindOne($field = 'COUNT(*)', $q = '')
  {
		return DC::$app->db->findOne('SELECT ' . $field . ' FROM `' . static::GetTableName() . '`' . $q);
	}
	public static function FindAllWhere($q = '')
  {
		if($q != '')
			$q = ' WHERE (' . $q . ')';
		return static::FindAll('SELECT * FROM `' . static::GetTableName() . '`' . $q);
	}
	public function DeleteWhere($q = '')
  {
		if($q != '')
			$q = ' WHERE (' . $q . ')';
		return DC::$app->db->query('DELETE FROM `' . $this->tableName . '`' . $q);
	}
	public static function Find($q)
  {
		$db = DC::$app->db;
		$rows = $db->find($q);
		if(!$rows)
			return null;
		$class = get_called_class();
		$item = new $class;
		foreach($rows as $key => $val)
			$item->{$key} = $val;
		return $item;
	}
	public static function FindAll($q)
  {
		$db = DC::$app->db;
		$rows = $db->findAll($q);
		if(!count($rows))
			return [];
		$items = [];
		foreach($rows as $row)
		{
			$class = get_called_class();
			$item = new $class;
			foreach($row as $key => $val)
				$item->{$key} = $val;
			$items[] = $item;
		}
		return $items;
	}
	public function Update()
  {
		$db = DC::$app->db;
		$prims = [];
		$others = [];
		$this->_fields($prims, $others);
		return $this->_update($prims, $others);
	}
	public function Save()
  {
		$db = DC::$app->db;
		$prims = [];
		$others = [];
		$this->_fields($prims, $others);
		if(count($prims) && $db->find('SELECT * FROM `' . $this->tableName . '` WHERE ' . $this->_set($prims, 'AND')))
			return $this->_update($prims, $others);
		$m = array_merge($prims, $others);
		return $this->_insert($m);
	}
	public function Delete()
  {
		$db = DC::$app->db;
		$prims = [];
		$others = [];
		$this->_fields($prims, $others);
		$db->query('DELETE FROM `' . $this->tableName . '` WHERE ' . $this->_set($prims, 'AND'));
	}
}