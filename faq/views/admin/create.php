<?php
/* @var $this FaqController */
/* @var $model Faq */
$this->breadcrumbs=array(
	'Faqs'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>Yii::t('FaqModule.faq','Manage Faq'), 'url'=>array('index')),
);
?>

<h1><? echo Yii::t('FaqModule.faq','Create Faq'); ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>