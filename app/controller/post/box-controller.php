<?php
namespace app\controller\post;
use core\dc\Controller;
use core\dc\DC;
use app\model\Article;
use app\model\Entity;
use app\model\Code;
class BoxController extends Controller
{
	public $anonym = null;
	public function beforeAction()
	{
		$this->formatJson();
	}
	public function actionCode()
	{
		$p = DC::$app->request->params;
		if(!isset($p['id']))
			return ['r' => 0, 'text' => 'Неверные входные параметры'];
		$id = (int)$p['id'];
		$code = null;
		if($id)
		{
			$code = Code::LoadById($id);
			if(!$code)
				return ['r' => 0, 'text' => 'Фрагмент кода не найден'];
		}
		return ['r' => 1, 'text' => $this->renderVar('code', ['code' => $code])];
	}
	public function actionSaveCode()
	{
		$p = DC::$app->request->params;
		if(!isset($p['id']) || !isset($p['name']) || !isset($p['type']) || !isset($p['number']) || !isset($p['content']))
			return ['r' => 0, 'text' => 'Неверные входные параметры'];
		if(!DC::$app->user)
			return ['r' => 0, 'text' => 'Только зарегистрированные пользователи могут выполнять это действие'];
		$id = (int)$p['id'];
		$name = trim($p['name']);
		$type = (int)$p['type'];
		$number = max(1, (int)$p['number']);
		$content = $p['content'];
		$errors = [];
		if(trim($content) == '')
			$errors[] = ['name' => 'content', 'text' => 'Фрагмент кода не должен быть пустым'];
		if(count($errors))
			return ['r' => 2, 'errors' => $errors];
		if($id)
		{
			$code = Code::LoadById($id);
			if(!$code)
				return ['r' => 0, 'text' => 'Фрагмент кода не найден'];
		}
		else
			$code = new Code;
		$code->name = $name;
		$code->type = $type;
		$code->number = $number;
		$code->content = $content;
		$code->creator = DC::$app->user->id;
		if($code->id && $code->update() || (!$code->id && $code->save()))
			return ['r' => 1, 'id' => $code->id, 'update' => $id, 'text' => $code->GetFormatContent(1)];
		return ['r' => 0, 'text' => 'Ошибка сохранения'];
	}
}