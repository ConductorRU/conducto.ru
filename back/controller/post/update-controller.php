<?php
namespace back\controller\post;
use back\updates\UpdateBase;
use core\dc\DC;
use core\dc\Controller;
class UpdateController extends Controller
{
	public function beforeAction()
	{
		$this->formatJson();
	}
	public function actionCreate()
	{
		$name = '';
		if(isset(DC::$app->request->params['name']))
			$name = DC::$app->request->params['name'];
		$r = UpdateBase::Create($name);
		$files = UpdateBase::getFiles();
		return ['r' => $r, 'html' => $this->renderVar('../main/_update', ['files' => $files])];
	}
	public function actionUpdate()
	{
		$upd = new UpdateBase;
		$r = $upd->exe();
		$files = UpdateBase::getFiles();
		return ['html' => $this->renderVar('../main/_update', ['files' => $files])];
	}
	public function actionDown()
	{
		$name = '';
		if(isset(DC::$app->request->params['name']))
			$name = DC::$app->request->params['name'];
		UpdateBase::UpdateDown($name);
		$files = UpdateBase::getFiles();
		return ['html' => $this->renderVar('../main/_update', ['files' => $files])];
	}
	public function actionDelete()
	{
		$name = '';
		if(isset(DC::$app->request->params['name']))
			$name = DC::$app->request->params['name'];
		$r = UpdateBase::Delete($name);
		$files = UpdateBase::getFiles();
		if($r)
			return ['r' => $r, 'html' => $this->renderVar('../main/_update', ['files' => $files])];
		return ['r' => $r, 'html' => ['text' => 'Файл ' . $name . '.php не существует']];
	}
}