<?php
/* @var $this FaqCatsController */
/* @var $model FaqCats */

$this->breadcrumbs=array(
	'Faq Cats'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>Yii::t('FaqModule.faq','Manage Cat'), 'url'=>array('index')),
	array('label'=>Yii::t('FaqModule.faq','Create Cat'), 'url'=>array('create')),
	array('label'=>Yii::t('FaqModule.faq','View Cat'), 'url'=>array('view', 'id'=>$model->id)),
);
?>

<h1><?php echo Yii::t('FaqModule.faq','Edit Cat'); ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>