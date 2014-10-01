<?php
/* @var $this FaqController */
/* @var $model Faq */

$this->breadcrumbs=array(
	'Faqs'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>Yii::t('FaqModule.faq','Manage Faq'), 'url'=>array('index')),
	array('label'=>Yii::t('FaqModule.faq','Create Faq'), 'url'=>array('create')),
	array('label'=>Yii::t('FaqModule.faq','Edit Faq'), 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>Yii::t('FaqModule.faq','Delete Faq'), 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>Yii::t('FaqModule.faq','Are you sure to delete this item?'))),
);
?>

<h1><? echo Yii::t('FaqModule.faq','View Faq'); ?></h1>

<?php
$attributes = array();
array_push($attributes,
		'id',
		'name',
		'email',
		'site',
		'question',
      array('name'=>'answer','value'=>$model->answer ? $model->answer : "Нет ответа"),
      array('name'=>'answered','value'=>Faq::itemAlias("Answered", $model->answered)),
      array('name'=>'published','value'=>Faq::itemAlias("Published", $model->published)),
		'create_at',
      array('name'=>'cid', 'value'=>FaqCats::model()->findByPk($model->cid)->name)
      );

$this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>$attributes
)); ?>
