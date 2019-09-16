<?php
namespace app\controller\post;
use core\dc\Controller;
use core\dc\DC;
use app\model\Article;
use app\model\Entity;
class ArticleController extends Controller
{
	public $anonym = null;
	public function beforeAction()
	{
		$this->formatJson();
	}
	public function actionSave()
	{
		$p = DC::$app->request->params;
		if(!isset($p['id']) || !isset($p['status']) || !isset($p['name']) || !isset($p['desc']) || !isset($p['content']))
			return ['r' => 0, 'text' => 'Неверные входные параметры'];
		if(!DC::$app->user)
			return ['r' => 0, 'text' => 'Только зарегистрированные пользователи могут выполнять это действие'];
		$id = (int)$p['id'];
		$status = (int)$p['status'];
		$name = trim($p['name']);
		$desc = preg_replace('~style="[^"]*"~i', '', trim($p['desc']));
		$content = preg_replace('~style="[^"]*"~i', '', trim($p['content']));
		$content = preg_replace('/<attach(.*?)>(.*?)<\/attach>/siu', '[attach $1]', $content);
		$errors = [];
		if($name == '')
			$errors[] = ['name' => 'name', 'text' => 'Название не должно быть пустым'];
		if(count($errors))
			return ['r' => 2, 'errors' => $errors];
		if($id)
		{
			$art = Article::LoadById($id);
			if(!$art)
				return ['r' => 0, 'text' => 'Статья не найдена'];
		}
		else
			$art = new Article;
		$art->entity_id = Entity::CreateId();
		$art->status = $status;
		$art->name = $name;
		$art->description = $desc;
		$art->content = $content;
		$art->creator = DC::$app->user->id;
		$art->updated_at = date('Y-m-d H:i:s');
		if(!$art->id)
			$art->created_at = $art->updated_at;
		if($art->id && $art->update() || (!$art->id && $art->save()))
			return ['r' => 1, 'path' => $art->GetUrl()];
		return ['r' => 0, 'text' => 'Ошибка сохранения'];
	}
	public function actionStatus()
	{
		$p = DC::$app->request->params;
		if(!isset($p['id']) || !isset($p['status']))
			return ['r' => 0, 'text' => 'Неверные входные параметры'];
		if(!DC::$app->user)
			return ['r' => 0, 'text' => 'Только зарегистрированные пользователи могут выполнять это действие'];
		$id = (int)$p['id'];
		$status = (int)$p['status'];
		$art = Article::LoadById($id);
		if(!$art)
			return ['r' => 0, 'text' => 'Статья не найдена'];
		$art->status = $status;
		$art->update();
		return ['r' => 1, 'status' => $art->status];
	}
	public function actionDelete()
	{
		$p = DC::$app->request->params;
		if(!isset($p['id']) || !isset($p['status']))
			return ['r' => 0, 'text' => 'Неверные входные параметры'];
		if(!DC::$app->user)
			return ['r' => 0, 'text' => 'Только зарегистрированные пользователи могут выполнять это действие'];
		$id = (int)$p['id'];
		$status = (int)$p['status'];
		$art = Article::LoadById($id);
		if(!$art)
			return ['r' => 0, 'text' => 'Статья не найдена'];
		$art->status = $status;
		$art->update();
		if($status)
			return ['r' => 1, 'html' => $this->renderVar('_content', ['article' => $art]), 'status' => $art->status];
		return ['r' => 1, 'html' => $this->renderVar('_recover', ['article' => $art]), 'status' => $art->status];
	}
}