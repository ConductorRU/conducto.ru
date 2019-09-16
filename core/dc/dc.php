<?php
namespace Core\DC;
class DC
{
	public static $app;
	public $root = '/';
	public $path = 'app';
	public $layout = 'main';
	public $config = [];
	public $request = null;
	public $user = null;
	public $dbs = [];
	public $langs = [];
	public $mem = null;
	public $session = null;
	public $version = 0;
	public function __construct()
	{
		static::$app = $this;
		$this->version = time();
		$this->root = __DIR__ . '/../../';
		$this->mem = new \Memcached();
		$this->mem->addServer('localhost', 11211);
		$this->session = new Session;
		if(isset($_COOKIE['id']) && isset($_COOKIE['email']) && isset($_COOKIE['hash']))
		{
			$this->session->set('id', $_COOKIE['id']);
			$this->session->set('email', $_COOKIE['email']);
			$this->session->set('hash', $_COOKIE['hash']);
		}
	}
	public function Print()
	{
		if(isset($this->config['route']))
			$rout = new Router($this->config['route']);
		else
			$rout = new Router();
		$rout->Action();
	}
	public static function t($text, $module)
	{
		if(!isset(static::$app->config['lang']))
			return $text;
		if(!isset(static::$app->langs[$module]))
		{
			static::$app->langs[$module] = [];
			$path = static::$app->root . static::$app->path . '/lang/' . static::$app->config['lang'] . '/' . $module . '.php';
			if(file_exists($path))
				static::$app->langs[$module] = include($path);
		}
		return isset(static::$app->langs[$module][$text]) ? static::$app->langs[$module][$text] : $text;
	}
	public static function Run($path = '')
	{
		$dc = new DC;
		include ($dc->root . $dc->path . '/config/common.php');
		foreach($common as $key => $val)
		{
			$dc->config[$key] = [];
			if(is_array($val))
			{
				foreach($val as $k => $v)
				{
					if($key == 'js' || $key == 'css')
					{
						$p = DC::$app->GetConfig('web');
						if($p != '')
							$p .= '/';
						$v = '/' . $v;
					}
					if(is_integer($k))
						$dc->config[$key][] = $v;
					else
						$dc->config[$key][$k] = $v;
				}
			}
			else
				$dc->config[$key] = $val;
		}
		if($path)
			$dc->path = $path;
		include ($dc->root . $dc->path . '/config/local.php');
		foreach($config as $key => $val)
		{
			if(!isset($dc->config[$key]))
				$dc->config[$key] = [];
			if(is_array($val))
			{
				foreach($val as $k => $v)
				{
					if($key == 'js' || $key == 'css')
					{
						$p = DC::$app->GetConfig('web');
						if($p != '')
							$p .= '/';
						$v = '/' . $v;
					}
					if(is_integer($k))
						$dc->config[$key][] = $v;
					else
						$dc->config[$key][$k] = $v;
				}
			}
			else
				$dc->config[$key] = $val;
		}
		if(isset($dc->config["userClass"]) && $dc->session->get('email') && $dc->session->get('hash'))
		{
			if($dc->config["userClass"]::IsExist())
			{
				$user = $dc->config["userClass"]::GetByHash($dc->session->get('email'), $dc->session->get('hash'));
				if($user)
					$dc->user = $user;
			}
		}
		$dc->request = new Request();
		$dc->Print();
	}
	public function GetConfig($name)
	{
		if(isset($this->config[$name]))
			return $this->config[$name];
		return '';
	}
	public function GetRoot()
	{
		if(isset($this->config['root']))
			return $this->config['root'];
		return $_SERVER['SERVER_NAME'];
	}
	public function __get($name) 
  {
		if(isset($this->dbs[$name]))
			return $this->dbs[$name];
		if(isset($this->config['sql'][$name]))
		{
			$par = $this->config['sql'][$name];
			$db = new DB($par['localhost'], $par['user'], $par['password'], $par['database']);
			if($db->sql->connect_error)
			{
				echo $db->sql->connect_error;
				return null;
			}
			$this->dbs[$name] = $db;
			return $this->dbs[$name];
		}
		return null;
	}
}