<?php

$adminMenu = array();

if (Yii::app()->controller->id=='posts'){
    $adminMenu[]= array('label' => 'Разделы', 'url' => array('postsTags/admin'));
}
if (Yii::app()->controller->id=='postsTags'){
    $adminMenu[]= array('label' => 'Публикации', 'url' => array('default/admin'));
}
$tags = PostsTags::model()->findAll();

$tagsMenu = array();
 $tagsMenu[] = array('label' => '> Черновик', 'url' => array('default/admin/tag_id/0'),'itemOptions'=>array('style'=>'margin-left:10px;'));
foreach ($tags as $tag){
    $tagsMenu[] = array('label' => '> '.$tag->tag_name, 'url' => array('default/admin/tag_id/'.$tag->id),'itemOptions'=>array('style'=>'margin-left:10px;'));
}

$this->menu = array_merge (
  $adminMenu,
  array(
    
    array('label' => 'Создать', 'url' => array('create')),
    array('label' => 'Все', 'url' => array('default/admin')),
),$tagsMenu);
?>
