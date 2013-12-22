<?php

class Migrations{
	public function isConfirmed($returnBoolean = false){
		return "Неизвестно";
	}

	public function getDescription()
	{
		return "Нету описания";
	}
	public function up()
	{
		return "Нету имплеметации";
	}

	public function down()
	{
		# code go here
	}

	public function execute($sql)
	{
		return Yii::app()->db->createCommand($sql)->execute();
	}

	public function confirmByWords($return)
	{
		if($return == true){
			return "Применена";
		}
		else{
			return "Еще не применялась";
		}

	}
}