<?php
namespace Core\DC;
class DC
{
	public static $app;
	public $root = '/';
	public $path = 'app';
	public $layout = 'main';
	public $config = null;
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
		$route = DC::$app->config->Get('route');
		if($route)
			$rout = new Router($route);
		else
			$rout = new Router();
		$rout->Action();
	}
	public static function t($text, $module)
	{
		$lang = DC::$app->config->Get('lang');
		if(!$lang)
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
		$locPath = $path ? $path : $dc->path;
		$dc->config = Config::Create($dc->root . $dc->path . '/config/common.php', $dc->root . $locPath . '/config/local.php');
		if($path)
			$dc->path = $path;
		$userClass = $dc->config->Get('userClass');
		if($userClass && $dc->session->get('email') && $dc->session->get('hash'))
		{
			if($userClass::IsExist())
			{
				$user = $userClass::GetByHash($dc->session->get('email'), $dc->session->get('hash'));
				if($user)
					$dc->user = $user;
			}
		}
		$dc->request = new Request();
		$dc->Print();
	}
	public function GetRoot()
	{
		$root = DC::$app->config->Get('userClass');
		if($root)
			return $root;
		return $_SERVER['SERVER_NAME'];
	}
	public function __get($name) 
  {
		if(isset($this->dbs[$name]))
			return $this->dbs[$name];
		$sql = DC::$app->config->Get('sql');
		if(isset($sql[$name]))
		{
			$par = $sql[$name];
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