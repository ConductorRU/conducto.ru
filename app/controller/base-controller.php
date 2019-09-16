<?php
namespace app\controller;
use core\dc\Controller;
use core\dc\DC;
use app\model\Visit;
use app\model\Anonym;
class BaseController extends Controller
{
	public function beforeAction()
	{
		Visit::AddVisit();
		Anonym::Get(false);
	}
}