<?php

class m141206_081712_create_promo_tables extends Migrations
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

        $sql = "DROP TABLE `promo`";
        $this->execute($sql);

        $sql = "DROP TABLE `promoRelation`";
        $this->execute($sql);

        return true;
	}

	public function getDescription()
	{
		return "Добавление таблиц для акции";
	}

	public function isConfirmed($returnBoolean = false){

		Yii::app()->db->schema->refresh();
		$table1 = Yii::app()->db->schema->getTable('promo');
		$result1 = isset($table1->columns['id']);

        $table2 = Yii::app()->db->schema->getTable('promoRelation');
		$result2 = isset($table1->columns['id']);

        $result = $result1 and $result2;

        if($returnBoolean){
        	return $result;
        }

        return parent::confirmByWords($result);
	}

}