<?php
namespace app\controller;
use core\dc\Controller;
use core\dc\DC;
class SettingsController extends Controller
{
	public function IsAjax()
	{
		$p = DC::$app->request->params;
		return ($this->isAjax && isset($p['selector']) && $p['selector'] == '#cont');
	}
	public function actionIndex()
	{
		$p = DC::$app->request->params;
		if($this->IsAjax())
			$this->render('_index');
		else
			$this->render('index', ['render' => '_index']);
	}
	public function actionInfo()
	{
		$p = DC::$app->request->params;
		if($this->IsAjax())
			$this->render('_info');
		else
			$this->render('index', ['render' => '_info']);
	}
	public function actionAbout()
	{
		$p = DC::$app->request->params;
		if($this->IsAjax())
			$this->render('_about');
		else
			$this->render('index', ['render' => '_about']);
	}
	public function actionContact()
	{
		$p = DC::$app->request->params;
		if($this->IsAjax())
			$this->render('_contact');
		else
			$this->render('index', ['render' => '_contact']);
	}
}