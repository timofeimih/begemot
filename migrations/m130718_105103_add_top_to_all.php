<?php

class m130718_105103_add_top_to_all extends CDbMigration
{
	public function up()
	{
        $sql = "ALTER TABLE `argo_posts`
	ADD COLUMN `top` INT NULL;";
        $this->execute($sql);


        return true;
	}

	public function down()
	{
		echo "m130718_105103_add_top_to_all does not support migration down.\n";
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