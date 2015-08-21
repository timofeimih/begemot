<?php

class m160000_123919_promo_order_set extends Migrations
{
	public function up()
	{
        if($this->isConfirmed(true) == true) return false;


        $tableData = Yii::app()->db->createCommand("SELECT * FROM promo ORDER BY id")->queryAll();
        foreach ($tableData as $key => $data) {
            $sql = "UPDATE promo SET `order`='" . $data['id'] ."' WHERE `id`='" . $data['id'] . "'";
            $this->execute($sql);
        }

        return true;
	}

	public function down()
	{
        if($this->isConfirmed(true) == false) return false;

        echo "m160000_123919_promo_order_set does not support migration down.\n";
        return false;
	}

    public function getDescription()
    {
        return "Добавление order данных для всех строк в таблице promo";
    }

    public function isConfirmed($returnBoolean = false){
        Yii::app()->db->schema->refresh();
        $table = Yii::app()->db->createCommand("SELECT * FROM promo LIMIT 1")->queryRow();

        $result = ($table['order'] > 0) ? true : false;
        

        if($returnBoolean){
            return $result;
        }

        return parent::confirmByWords($result);
    }
}