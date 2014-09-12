<?php

class m130718_105103_add_top_to_all extends Migrations
{
	public function up()
	{
		if($this->isConfirmed(true) == true) return false;
		
        $sql = "ALTER TABLE `argo_posts`
	ADD COLUMN `top` INT NULL;";
        $this->execute($sql);


        return true;
	}

	public function down()
	{
		if($this->isConfirmed(true) == false) return false;

		echo "m130718_105103_add_top_to_all does not support migration down.\n";
		return false;
	}


	public function isConfirmed($returnBoolean = false){
		$table = Yii::app()->db->schema->getTable('argo_posts');
		$result = isset($table->columns['top']);

        if($returnBoolean){
        	return $result;
        }

        return parent::confirmByWords($result);
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