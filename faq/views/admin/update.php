<?php
/* @var $this FaqController */
/* @var $model Faq */

$this->breadcrumbs=array(
	'Faqs'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>Yii::t('FaqModule.faq','Create Faq'), 'url'=>array('create')),
	array('label'=>Yii::t('FaqModule.faq','Manage Faq'), 'url'=>array('index')),
	array('label'=>Yii::t('FaqModule.faq','View Faq'), 'url'=>array('view', 'id'=>$model->id)),
);
?>

<h1><?php echo Yii::t('FaqModule.faq','Update Faq'); ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>