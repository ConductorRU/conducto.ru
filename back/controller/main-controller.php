<?php
namespace back\controller;
use core\dc\Controller;
class MainController extends Controller
{
	public function actionIndex()
	{
		$this->render('index');
	}
	public function actionUpdate()
	{
		$this->render('update');
	}
}