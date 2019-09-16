<?php
namespace app\controller;
use core\dc\Controller;
use core\dc\DC;
class LongController extends Controller
{
	public function beforeAction()
	{
		$this->formatJson();
	}
	public function actionListen()
	{
		$lists = [];
		if(isset(DC::$app->request->params['listeners']))
			$lists = json_decode(DC::$app->request->params['listeners']);
		$sid = 'lis_' . DC::$app->session->GetId();
		DC::$app->mem->set($sid, $lists, 600);
		DC::$app->db->query('UPDATE test SET `time`=\'' . serialize($lists) . '\' WHERE `id` = 1');
	}
	public function actionIndex()
	{
		$sid = 'lis_' . DC::$app->session->GetId();
		DC::$app->session->Close();
		$p = DC::$app->request->params;
		
		if(isset($p['listeners']))
		{
			$lists = json_decode($p['listeners']);
			DC::$app->mem->set($sid, $lists, 600);
		}
		
		$mem = DC::$app->mem;
		$items = ['r' => 's', 'num' => $p['num'], 'count' => (int)$p['count'], 'data' => []];
		$micSec = 200000;
		$elp = 0;
		$start = time();
		$limit = 300;
		$lis = [];
		ignore_user_abort(true);
		while($elp < $limit)
		{
			echo "\n";
			flush();
			ob_flush();
			if(connection_status() != CONNECTION_NORMAL)
			{
				ob_end_clean();
				break;
			}
			$li = $mem->get($sid);
			if($li)
				$lis = $li;
			foreach($lis as $key => &$l)
			{
				$exl = explode('_', $key);
				if(count($exl) >= 2)
				{
					$iType = $exl[0];
					if($iType == 'chat')
					{
						$iId = $exl[1];
						$post = $mem->get('chat' . $iId);
						if($post)
						{
							$last = $l->last;
							$cnt = ($post - $last);
							if($cnt)
							{
								$chat = \app\model\Chat::LoadById($iId);
								$posts = $chat->GetPosts($last, 0, $cnt);
								$l->last = $post;
								$mem->delete('chat' . $iId);
								$items['data'][] = ['name' => $key, 'value' => $this->renderVar('../chat/_posts', ['posts' => $posts]), 'data' => $l];
								$mem->set($sid, $lis, 600);
							}
						}
					}
					else if($iType == 'im')
					{
						$i1 = $exl[1];
						$i2 = $exl[2];
						$post = $mem->get('im_' . $i1 . '_' . $i2);
						if($post)
						{
							$last = $l->last;
							$cnt = ($post - $last);
							if($cnt)
							{
								$dia = \app\model\Dialog::LoadByUsers($i1, $i2);
								$posts = $dia->GetPosts($last, 0, $cnt);
								DC::$app->db->query('UPDATE test SET `time`="' . $last . '_' . $cnt . '_' . $post . '" WHERE `id` = 5');
								$l->last = $post;
								$mem->delete('im_' . $i1 . '_' . $i2);
								$items['data'][] = ['name' => $key, 'value' => $this->renderVar('../chat/_posts', ['posts' => $posts]), 'data' => $l];
								$mem->set($sid, $lis, 600);
							}
						}
					}
				}
			}
			if(count($items['data']))
				return $items;
			usleep($micSec);
			$elp = time() - $start;
		}
			
		return $items;
	}
}