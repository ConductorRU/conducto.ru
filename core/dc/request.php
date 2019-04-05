<?php
namespace Core\DC;
class Request
{
	public $uri = '';
	public $url = '';
	public $params = [];
	public $isPost = false;
	function __construct()
	{
		$this->uri = $_SERVER['REQUEST_URI'];
		$this->uri = preg_replace('/^\/' . DC::$app->config->Get('web') . '/', '', $this->uri);
		$v = explode('?', $this->uri);
		$this->url = preg_replace('/^\//', '', $v[0]);
		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
			$this->isPost = true;
		if($_SERVER['REQUEST_METHOD'] == 'GET')
			$this->params = $_GET;
		else if($_SERVER['REQUEST_METHOD'] == 'POST')
		{
			$this->params = array_merge($_GET, $_POST);
			$this->isPost = true;
		}
	}
	
}