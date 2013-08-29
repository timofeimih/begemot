<?php

class m130818_093531_add_url_to_seo_group extends CDbMigration
{
	public function up()
	{
        $sql = "ALTER TABLE `seo_word_group`
	ADD COLUMN `url` TEXT NULL;";
        return $this->execute($sql);
	}

	public function down()
	{
		echo "m130818_093531_add_url_to_seo_group does not support migration down.\n";
		return false;
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}