<?php
namespace back\updates;
use core\dc\DC;
class m1498731085_attribute extends UpdateBase
{
	public function up()
	{
		$db = DC::$app->db;
		$db->CreateTable('entity_type',
		[
			'id' => 'TINYINT UNSIGNED NOT NULL PRIMARY KEY',
			'name' => 'VARCHAR(255) NOT NULL',
		]);
		$db->CreateTable('attribute_type',
		[
			'id' => 'TINYINT UNSIGNED NOT NULL PRIMARY KEY',
			'code' => 'VARCHAR(32) NOT NULL',
			'multi' => 'TINYINT UNSIGNED NOT NULL DEFAULT 0',
		]);
		$db->CreateTable('attribute',
		[
			'id' => 'int(11) UNSIGNED NOT NULL PRIMARY KEY',
			'type' => 'TINYINT UNSIGNED NOT NULL',
			'name' => 'VARCHAR(255) NOT NULL',
		]);
		$db->AddForeignKey('attribute_type_fk', 'attribute', 'type', 'attribute_type', 'id', 'CASCADE', 'CASCADE');
		
		$db->CreateTable('attribute_int',
		[
			'attribute_id' => 'int(11) UNSIGNED NOT NULL',
			'entity_type' => 'TINYINT UNSIGNED NOT NULL',
			'entity_id' => 'bigint(11) UNSIGNED NOT NULL',
			'value' => 'int(11) NOT NULL'
		]);
		$db->AddPrimaryKey('attribute_int_pk', 'attribute_int', ['attribute_id', 'entity_type', 'entity_id']);
		$db->AddForeignKey('attribute_int_type', 'attribute_int', 'entity_type', 'entity_type', 'id', 'CASCADE', 'CASCADE');
		$db->AddForeignKey('attribute_int_entity', 'attribute_int', 'entity_id', 'entity', 'id', 'CASCADE', 'CASCADE');
		$db->AddForeignKey('attribute_int_id', 'attribute_int', 'attribute_id', 'attribute', 'id', 'CASCADE', 'CASCADE');
		
		$db->CreateTable('attribute_name',
		[
			'attribute_id' => 'int(11) UNSIGNED NOT NULL',
			'entity_type' => 'TINYINT UNSIGNED NOT NULL',
			'entity_id' => 'bigint(11) UNSIGNED NOT NULL',
			'value' => 'VARCHAR(255) NOT NULL'
		]);
		$db->AddPrimaryKey('attribute_name_pk', 'attribute_name', ['attribute_id', 'entity_type', 'entity_id']);
		$db->AddForeignKey('attribute_name_type', 'attribute_name', 'entity_type', 'entity_type', 'id', 'CASCADE', 'CASCADE');
		$db->AddForeignKey('attribute_name_entity', 'attribute_name', 'entity_id', 'entity', 'id', 'CASCADE', 'CASCADE');
		$db->AddForeignKey('attribute_name_id', 'attribute_name', 'attribute_id', 'attribute', 'id', 'CASCADE', 'CASCADE');
		
		$db->CreateTable('attribute_string',
		[
			'attribute_id' => 'int(11) UNSIGNED NOT NULL',
			'entity_type' => 'TINYINT UNSIGNED NOT NULL',
			'entity_id' => 'bigint(11) UNSIGNED NOT NULL',
			'value' => 'VARCHAR(65535) NOT NULL'
		]);
		$db->AddPrimaryKey('attribute_string_pk', 'attribute_string', ['attribute_id', 'entity_type', 'entity_id']);
		$db->AddForeignKey('attribute_string_type', 'attribute_string', 'entity_type', 'entity_type', 'id', 'CASCADE', 'CASCADE');
		$db->AddForeignKey('attribute_string_entity', 'attribute_string', 'entity_id', 'entity', 'id', 'CASCADE', 'CASCADE');
		$db->AddForeignKey('attribute_string_id', 'attribute_string', 'attribute_id', 'attribute', 'id', 'CASCADE', 'CASCADE');
		
		$db->CreateTable('attribute_text',
		[
			'attribute_id' => 'int(11) UNSIGNED NOT NULL',
			'entity_type' => 'TINYINT UNSIGNED NOT NULL',
			'entity_id' => 'bigint(11) UNSIGNED NOT NULL',
			'value' => 'MEDIUMTEXT NOT NULL'
		]);
		$db->AddPrimaryKey('attribute_text_pk', 'attribute_text', ['attribute_id', 'entity_type', 'entity_id']);
		$db->AddForeignKey('attribute_text_type', 'attribute_text', 'entity_type', 'entity_type', 'id', 'CASCADE', 'CASCADE');
		$db->AddForeignKey('attribute_text_entity', 'attribute_text', 'entity_id', 'entity', 'id', 'CASCADE', 'CASCADE');
		$db->AddForeignKey('attribute_text_id', 'attribute_text', 'attribute_id', 'attribute', 'id', 'CASCADE', 'CASCADE');
		
		
		
		$db->CreateTable('attribute_ints',
		[
			'attribute_id' => 'int(11) UNSIGNED NOT NULL',
			'entity_type' => 'TINYINT UNSIGNED NOT NULL',
			'entity_id' => 'bigint(11) UNSIGNED NOT NULL',
			'num' => 'int(11) UNSIGNED NOT NULL DEFAULT 0',
			'value' => 'int(11) NOT NULL'
		]);
		$db->AddPrimaryKey('attribute_ints_pk', 'attribute_ints', ['attribute_id', 'entity_type', 'entity_id', 'num']);
		$db->AddForeignKey('attribute_ints_type', 'attribute_ints', 'entity_type', 'entity_type', 'id', 'CASCADE', 'CASCADE');
		$db->AddForeignKey('attribute_ints_entity', 'attribute_ints', 'entity_id', 'entity', 'id', 'CASCADE', 'CASCADE');
		$db->AddForeignKey('attribute_ints_id', 'attribute_ints', 'attribute_id', 'attribute', 'id', 'CASCADE', 'CASCADE');
		$db->AddIndex('attribute_ints_list', 'attribute_ints', ['attribute_id', 'entity_id']);
		
		$db->CreateTable('attribute_names',
		[
			'attribute_id' => 'int(11) UNSIGNED NOT NULL',
			'entity_type' => 'TINYINT UNSIGNED NOT NULL',
			'entity_id' => 'bigint(11) UNSIGNED NOT NULL',
			'num' => 'int(11) UNSIGNED NOT NULL DEFAULT 0',
			'value' => 'VARCHAR(255) NOT NULL'
		]);
		$db->AddPrimaryKey('attribute_names_pk', 'attribute_names', ['attribute_id', 'entity_type', 'entity_id', 'num']);
		$db->AddForeignKey('attribute_names_type', 'attribute_names', 'entity_type', 'entity_type', 'id', 'CASCADE', 'CASCADE');
		$db->AddForeignKey('attribute_names_entity', 'attribute_names', 'entity_id', 'entity', 'id', 'CASCADE', 'CASCADE');
		$db->AddForeignKey('attribute_names_id', 'attribute_names', 'attribute_id', 'attribute', 'id', 'CASCADE', 'CASCADE');
		$db->AddIndex('attribute_names_list', 'attribute_names', ['attribute_id', 'entity_id']);
		
		$db->CreateTable('attribute_strings',
		[
			'attribute_id' => 'int(11) UNSIGNED NOT NULL',
			'entity_type' => 'TINYINT UNSIGNED NOT NULL',
			'entity_id' => 'bigint(11) UNSIGNED NOT NULL',
			'num' => 'int(11) UNSIGNED NOT NULL DEFAULT 0',
			'value' => 'VARCHAR(65535) NOT NULL'
		]);
		$db->AddPrimaryKey('attribute_strings_pk', 'attribute_strings', ['attribute_id', 'entity_type', 'entity_id', 'num']);
		$db->AddForeignKey('attribute_strings_type', 'attribute_strings', 'entity_type', 'entity_type', 'id', 'CASCADE', 'CASCADE');
		$db->AddForeignKey('attribute_strings_entity', 'attribute_strings', 'entity_id', 'entity', 'id', 'CASCADE', 'CASCADE');
		$db->AddForeignKey('attribute_strings_id', 'attribute_strings', 'attribute_id', 'attribute', 'id', 'CASCADE', 'CASCADE');
		$db->AddIndex('attribute_strings_list', 'attribute_strings', ['attribute_id', 'entity_id']);
		
		$db->CreateTable('attribute_texts',
		[
			'attribute_id' => 'int(11) UNSIGNED NOT NULL',
			'entity_type' => 'TINYINT UNSIGNED NOT NULL',
			'entity_id' => 'bigint(11) UNSIGNED NOT NULL',
			'num' => 'int(11) UNSIGNED NOT NULL DEFAULT 0',
			'value' => 'MEDIUMTEXT NOT NULL'
		]);
		$db->AddPrimaryKey('attribute_texts_pk', 'attribute_texts', ['attribute_id', 'entity_type', 'entity_id', 'num']);
		$db->AddForeignKey('attribute_texts_type', 'attribute_texts', 'entity_type', 'entity_type', 'id', 'CASCADE', 'CASCADE');
		$db->AddForeignKey('attribute_texts_entity', 'attribute_texts', 'entity_id', 'entity', 'id', 'CASCADE', 'CASCADE');
		$db->AddForeignKey('attribute_texts_id', 'attribute_texts', 'attribute_id', 'attribute', 'id', 'CASCADE', 'CASCADE');
		$db->AddIndex('attribute_texts_list', 'attribute_texts', ['attribute_id', 'entity_id']);
		
		\app\model\EntityType::Create(1, 'user');
		\app\model\EntityType::Create(2, 'chat');
		
		\app\model\AttributeType::Create(1, 'int', 0);
		\app\model\AttributeType::Create(2, 'name', 0);
		\app\model\AttributeType::Create(3, 'string', 0);
		\app\model\AttributeType::Create(4, 'text', 0);
		\app\model\AttributeType::Create(5, 'ints', 1);
		\app\model\AttributeType::Create(6, 'names', 1);
		\app\model\AttributeType::Create(7, 'strings', 1);
		\app\model\AttributeType::Create(8, 'texts', 1);
		
	}
	public function down()
	{
		$db = DC::$app->db;
		$db->DropTable('attribute_texts');
		$db->DropTable('attribute_strings');
		$db->DropTable('attribute_names');
		$db->DropTable('attribute_ints');
		$db->DropTable('attribute_text');
		$db->DropTable('attribute_string');
		$db->DropTable('attribute_name');
		$db->DropTable('attribute_int');
		$db->DropTable('attribute');
		$db->DropTable('attribute_type');
	}
}
