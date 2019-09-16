<?php
namespace back\updates;
use core\dc\DC;
use app\model\Attribute;
use app\model\AttributeType;
class m1499154508_user_prop extends UpdateBase
{
	public function up()
	{
		$tName = AttributeType::GetIdByCode('name');
		$tString = AttributeType::GetIdByCode('string');
		Attribute::Create(1, 'User Name', $tName);
		Attribute::Create(2, 'User Second Name', $tName);
		Attribute::Create(3, 'User Patre Name', $tName);
		
		Attribute::Create(4, 'Activity', $tString);
		Attribute::Create(5, 'Interests', $tString);
		Attribute::Create(6, 'Favorite music', $tString);
		Attribute::Create(7, 'Favorite films', $tString);
		Attribute::Create(8, 'Favorite games', $tString);
		Attribute::Create(9, 'Favorite quotes', $tString);
		
		$db = DC::$app->db;
		$db->AddColumn('user', 'birth_date', 'DATE DEFAULT NULL', 'email');
	}
	public function down()
	{
		$db = DC::$app->db;
		for($i = 1; $i <= 9; ++$i)
			Attribute::LoadById($i)->Delete();
		$db->DropColumn('user', 'birth_date');
	}
}
