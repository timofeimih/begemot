<?php

class m130718_091257_top_item extends CDbMigration
{
	public function up()
	{
        $sql = "ALTER TABLE `catItems`
	ADD COLUMN `top` INT NULL AFTER `authorId`;";
        $this->execute($sql);
	}

	public function down()
	{
        $sql = "ALTER TABLE `catItems`
	DROP COLUMN `top`;";
        $this->execute($sql);
	}

	/*
	 * ALTER TABLE `catItems`
	DROP COLUMN `top`;
	 *
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}