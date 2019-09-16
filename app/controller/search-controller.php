<?php
namespace app\controller;
use core\dc\Controller;
use core\dc\DC;
use app\model\helper\Search;
class SearchController extends Controller
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
			$this->render('index', ['render' => '_index', 'data' => []]);
	}
	public function actionUsers()
	{
		$p = DC::$app->request->params;
		$q = isset($p['q']) ? $p['q'] : '';
		$start = isset($p['start']) ? (int)$p['start'] : 0;
		$max_id = isset($p['max_id']) ? (int)$p['max_id'] : 0;
		$users = Search::SearchUsers($q, $start, 20, $max_id);
		if($this->IsAjax())
			$this->render('_users', ['users' => $users]);
		else if(!$start)
			$this->render('index', ['render' => '_users', 'data' => ['users' => $users]]);
		else
			$this->render('_list_users', ['users' => $users]);
	}
	public function actionChats()
	{
		$p = DC::$app->request->params;
		$q = isset($p['q']) ? $p['q'] : '';
		$start = isset($p['start']) ? (int)$p['start'] : 0;
		$max_id = isset($p['max_id']) ? (int)$p['max_id'] : 0;
		$chats = Search::SearchChats($q, $start, 20, $max_id);
		if($this->IsAjax())
			$this->render('_chats', ['chats' => $chats]);
		else if(!$start)
			$this->render('index', ['render' => '_chats', 'data' => ['chats' => $chats]]);
		else
			$this->render('_list_chats', ['chats' => $chats]);
	}
	public function actionTasks()
	{
		$p = DC::$app->request->params;
		$q = isset($p['q']) ? $p['q'] : '';
		$tasks = Search::SearchTasks($q);
		if($this->IsAjax())
			$this->render('_tasks', ['tasks' => $tasks]);
		else
			$this->render('index', ['render' => '_tasks', 'data' => ['tasks' => $tasks]]);
	}
	public function actionArticles()
	{
		$p = DC::$app->request->params;
		$q = isset($p['q']) ? $p['q'] : '';
		$articles = Search::SearchArticles($q);
		if($this->IsAjax())
			$this->render('_articles', ['articles' => $articles]);
		else
			$this->render('index', ['render' => '_articles', 'data' => ['articles' => $articles]]);
	}
}