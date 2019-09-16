<?php
namespace app\controller;
use core\dc\Controller;
use core\dc\DC;
use app\model\Article;
class ArticleController extends BaseController
{
	public function GetArticle()
	{
		$id = isset(DC::$app->request->params['id']) ? (int)DC::$app->request->params['id'] : 0;
		if(!$id)
			return null;
		$article = Article::LoadById($id);
		if(!$article)
			return null;
		return $article;
	}
	public function actionIndex()
	{
		$article = $this->GetArticle();
		if(!$article)
			return $this->Error();
		if($article->status == 0 || ($article->status == 2 && (!DC::$app->user || DC::$app->user->id != $article->creator)))
			return $this->Deny();
		$this->render('index', ['article' => $article]);
	}
	public function actionCreate()
	{
		$this->render('create');
	}
	public function actionEdit()
	{
		$article = $this->GetArticle();
		if(!$article)
			return $this->Error();
		if(!DC::$app->user || $article->creator != DC::$app->user->id)
			return $this->Deny();
		$this->render('edit', ['article' => $article]);
	}
	public function actionArticles()
	{
		$userId = 0;
		if(DC::$app->user)
			$userId = DC::$app->user->id;
		$list = Article::GetList($userId, 0, 20);
		$this->render('articles', ['articles' => $list]);
	}
}