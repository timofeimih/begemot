<?php

$this->menu=array(
    array('label'=>Yii::t('FaqModule.faq','Create Faq'), 'url'=>array('create')),
    array('label'=>Yii::t('FaqModule.faq','Manage Cat'), 'url'=>array('cats/')),
    array('label'=>Yii::t('FaqModule.faq','Categs')),
    array('label'=>Yii::t('FaqModule.faq','Moderation'), 'url'=>array('index')),
);

$cats = FaqCats::model()->findAll();

foreach($cats as $cat){
   $this->menu[] = array('label'=>$cat->name, 'url'=>array('index', 'cid'=>$cat->id));
}
$this->menu[] = array('label'=>'Добавить раздел', 'url'=>array('cats/create'));
?>
