<?php
namespace app\controller;
use core\dc\Controller;
use core\dc\DC;
use app\model\Album;
class AlbumController extends BaseController
{
	public function actionCreate()
	{
		$this->render('create');
	}
	public function actionAlbums()
	{
		$userId = 0;
		if(DC::$app->user)
			$userId = DC::$app->user->id;
		$list = Album::GetList($userId, 0, 20);
		$this->render('albums', ['albums' => $list]);
	}
}