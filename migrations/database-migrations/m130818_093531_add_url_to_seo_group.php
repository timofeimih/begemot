<?php

class m130818_093531_add_url_to_seo_group extends Migrations
{
	public function up()
	{
		if($this->isConfirmed(true) == true) return false;
		
        $sql = "ALTER TABLE `seo_word_group`
	ADD COLUMN `url` TEXT NULL;";
        return $this->execute($sql);
	}

	public function down()
	{
		if($this->isConfirmed(true) == false) return false;

		echo "m130818_093531_add_url_to_seo_group does not support migration down.\n";
		return false;
	}


	public function isConfirmed($returnBoolean = false){
		$table = Yii::app()->db->schema->getTable('seo_word_group');
		$result = isset($table->columns['url']);

        if($returnBoolean){
        	return $result;
        }

        return parent::confirmByWords($result);
	}
}