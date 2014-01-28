<?php

class cls_1387798915 extends Migrations
{
	public function up()
	{

		if($this->isConfirmed(true) == true) return false;

        $sql = "CREATE TABLE IF NOT EXISTS `catItemsToItems` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `itemId` int(11) NOT NULL,
  `toItemId` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;";
        $this->execute($sql);

        return true;
	}

	public function down()
	{
		if($this->isConfirmed(true) == false) return false;

        $sql = "DROP TABLE `catItemsToItems`";
        $this->execute($sql);

        return true;
	}

	public function getDescription()
	{
		return "Добавление таблицы для привязки карточек к карточкам";
	}

	public function isConfirmed($returnBoolean = false){
		Yii::app()->db->schema->refresh();
		$table = Yii::app()->db->schema->getTable('CatItems');
		$result = isset($table->columns['itemId']);

        if($returnBoolean){
        	return $result;
        }

        return parent::confirmByWords($result);
	}

}