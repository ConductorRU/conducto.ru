<?php
namespace back\updates;
use core\dc\DC;
use app\model\helper\Generator;
class m1499921069_generator extends UpdateBase
{
	public function up()
	{
		Generator::GenerateUsers(100);
		Generator::GenerateChats(100);
	}
	public function down()
	{
		Generator::Clear();
	}
}
