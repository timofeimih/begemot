<?php

class m130818_093533_parsers_stock extends Migrations
{
	public function up()
	{

		if($this->isConfirmed(true) == true) return false;

        $sql = "CREATE TABLE IF NOT EXISTS `parsers_stock` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `fromId` varchar(255) NOT NULL,
		  `toId` int(11) NOT NULL,
		  PRIMARY KEY (`id`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;";
        $this->execute($sql);

        return true;
	}

	public function down()
	{
		if($this->isConfirmed(true) == false) return false;

        $sql = "DROP TABLE `parsers_stock`";
        $this->execute($sql);

        return true;
	}

	public function getDescription()
	{
		return "Добавление таблицы для привязки парсера к карточкам";
	}

	public function isConfirmed($returnBoolean = false){
		Yii::app()->db->schema->refresh();
		$table = Yii::app()->db->schema->getTable('parsers_stock');
		$result = isset($table->columns['id']);

        if($returnBoolean){
        	return $result;
        }

        return parent::confirmByWords($result);
	}
}