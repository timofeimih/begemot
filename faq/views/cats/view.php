<?php
/* @var $this FaqCatsController */
/* @var $model FaqCats */

$this->breadcrumbs=array(
	'Faq Cats'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>Yii::t('FaqModule.faq','Manage Cat'), 'url'=>array('index')),
	array('label'=>Yii::t('FaqModule.faq','Create Cat'), 'url'=>array('create')),
	array('label'=>Yii::t('FaqModule.faq','Edit Cat'), 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>Yii::t('FaqModule.faq','Delete Cat'), 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
);
?>

<h1><?php echo Yii::t('FaqModule.faq','View Cat');?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
	),
)); ?>
