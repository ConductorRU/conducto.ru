<?php
namespace core\dc;
use core\dc\View;
class Controller
{
	public $path = '';
	public $view = null;
	public $isJson = 0;
	public $isAjax = 0;
	public $isError = false;
	public $errors = [];
	function __construct()
	{
		$ar = explode('\\', get_called_class());
		$class = end($ar);
		$this->path = str_replace('controller', '', mb_strtolower($class)) . '/';
		if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
			$this->isAjax = 1;
	}
	public function beforeAction()
	{
	}
	public function afterAction()
	{
		
	}
	public function AddError($field, $tip)
	{
		$this->errors[] = ['name' => $field, 'text' => $tip];
	}
	public function IsErrors()
	{
		return count($this->errors) != 0;
	}
	public function GetErrors()
	{
		return $this->errors;
	}
	public function formatJson()
	{
		header("Content-type: application/json;charset=utf-8");
		$this->isJson = true;
	}
	public function render($view, $vars = [])
	{
		$v = new View($this, $view);
		if(DC::$app->request->isPost)
			$v->renderJson($vars);
		else
			$v->renderPage($vars);
	}
	public function renderPartial($view, $vars = [])
	{
		$v = new View($this, $view);
		$v->renderPartial($vars);
	}
	public function renderVar($view, $vars = [])
	{
		$v = new View($this, $view);
		return $v->renderVar($vars);
	}
	public function actionIndex()
	{
		$this->render('index');
	}
	public function Error()
	{
		$this->isError = true;
		$this->render('../main/404');
	}
	public function Deny()
	{
		$this->isError = true;
		$this->render('../main/deny');
	}
}