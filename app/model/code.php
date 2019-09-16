<?php
namespace app\model;
use core\dc\Model;
class Code extends Model
{
	public static $TYPE = [0 => 'default', 1 => 'cpp'];
	public static function LoadById($id)
	{
		return Code::FindWhere('id=' . $id);
	}
	public function GetFormatContent($isEdit = 0)
	{
		$c = $this->content;
		$c = preg_replace('/\n/siu', '<br>', $c);
		$c = preg_replace('/\t/siu', '<i class="tab"></i>', $c);
		$cnt = substr_count($c, '<br>');
		$keys = ['/void/', '/return/'];
		$c = preg_replace($keys, '<span style="color:#0000ff">$0</span>', $c);
		$t = '<attach ' . ($isEdit ? 'class="nosel" contenteditable="false" ' : '') . 'data-type="code" data-value="' . $this->id . '">';
		$t .= '<div class="codebox code_' . Code::$TYPE[$this->type] . '">';
		$t .= '<div class="head"><span>' . $this->name . '</span>';
		if($isEdit)
		{
			$t .= '<div class="sets">';
			$t .= '<i class="fa fa-cog" onclick="main.FormatOpenCode(' . $this->id . ')" title="Редактировать"></i>';
			$t .= '<i class="fa fa-times" onclick="main.FormatDeleteCode(' . $this->id . ')" title="Удалить"></i></div>';
		}
		$t .= '</div><div class="body">';
		$t .= '<div class="nums">';
		$start = max(1, $this->number);
		$cnt = $start + $cnt;
		for($i = $start; $i <= $cnt; ++$i)
			$t .= $i . '<br>';
		$t .= '</div><div class="words">';
		$t .= $c;
		$t .= '</div></div></div>';
		$t .= '</attach><br>';
		return $t;
	}
}