<?php 

$this->menu=array(
	array('label' => 'Все парсеры', 'url' => array('/parsers/default/index')),
	array('label' => '------------------------------------------------'),
    array('label' => 'Все связи', 'url' => array('/parsers/default/linking')),
    array('label' => '------------------------------------------------'),
    array('label' => 'Cоздать новую связанную категорию', 'url'=>array('/parsers/parsersCategoryConnection/create')),
	array('label' => 'Все связанные категории', 'url'=>array('/parsers/parsersCategoryConnection/admin')),	
);
 ?>