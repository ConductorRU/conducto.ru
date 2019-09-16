<?php
namespace mobile\controller;
use core\dc\Controller;
use core\dc\DC;
use app\model\Visit;
use app\model\Anonym;
class BaseController extends Controller
{
	public function beforeAction()
	{
		$this->formatJson();
		Visit::AddVisit();
		Anonym::Get(false);
	}
}