<?php
namespace Core\DC;
class Router
{
	public $rules = [];
	function __construct($config = [])
	{
		$this->rules = $config;
	}
	static protected function IsRule($url, $path, &$vars)
	{
		$vars = [];
		$ms = [];
		if($url == $path)
			return true;
		if(preg_match_all('/<(.*?)>/', $path, $ms, PREG_SET_ORDER))
		{
			$rule = $path;
			$pars = [];
			foreach($ms as $m)
			{
				$para = explode(':', $m[1]);
				if(count($para) == 2)
				{
					$reg = '(' . $para[1] . ')';
					//if($para[1] == '\\d+')
					//	$reg = '([0-9]+)';
					if($reg)
					{
						$pars[] = $para[0];
						$rule = str_replace($m[0], $reg, $rule);
					}
				}
				else if(count($para) == 1)
				{
					if($para[0] == 'action' || $para[0] == 'controller')
					{
						$reg = '([A-z0-9_-]+)';
						$pars[] = $para[0];
						$rule = str_replace($m[0], $reg, $rule);
					}
				}
			}
			if(preg_match('%^' . $rule . '$%', $url, $ms))
			{
				for($i = 1; $i < count($ms); ++$i)
					$vars[$pars[$i - 1]] = $ms[$i];
				return true;
			}
		}
		return false;
	}
	static protected function GetAction($rule, &$params, &$cont, &$action)
	{
		$act = '';
		if(isset($params['action']))
		{
			$rule = str_replace('<action>', $params['action'], $rule);
			$act = $params['action'];
			unset($params['action']);
		}
		if(isset($params['controller']))
		{
			$rule = str_replace('<controller>', $params['controller'], $rule);
			$cont = $params['controller'];
			unset($params['controller']);
		}
		$ex = explode('/', $rule);
		if($cont)
		{
			$v = '';
			foreach($ex as $e)
			{
				if($e == $cont)
					break;
				$v .= $e . '\\';
			}
			$cont = $v . $cont;
		}
		else
			$cont = $ex[0];
		if(!$act)
		{
			if(count($ex) > 1)
				$act = $ex[1];
			if(!$act)
				$act = 'index';
		}
		$action = $act;
	}
	public function Action()
	{
		$cont = null;
		if(!count($this->rules))
		{
			$cont = new \app\controller\MainController;
			$cont->beforeAction();
			$cont->actionIndex();
			return;
		}
		$req = DC::$app->request;
		$url = $req->url;
		$cont = '';
		$act = '';
		$vars = [];
		foreach($this->rules as $path => $rule)
		{
			if(static::IsRule($url, $path, $vars))
			{
				foreach($vars as $key => $val)
					$req->params[$key] = $val;
				static::GetAction($rule, $req->params, $cont, $act);
				if($cont && $act)
				{
					$cont = '\\' . DC::$app->path . '\\controller\\' . ucfirst($cont) . 'Controller';
					$act = 'action' . ucfirst(preg_replace('%-([A-z])%iu', '$1', $act));
					if(!method_exists($cont, $act))
					{
						$cont = new \app\controller\MainController;
						$cont->Error();
						return;
					}
					$control = new $cont;
					$control->beforeAction();
					$ret = $control->$act();
					$control->afterAction();
					if($control->isJson)
						echo json_encode($ret);
					$isAct = 1;
				}
				return;
			}
		}
		$cont = new \app\controller\MainController;
		$cont->Error();
	}
}