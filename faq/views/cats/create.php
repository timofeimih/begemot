<?php
/* @var $this FaqCatsController */
/* @var $model FaqCats */

$this->breadcrumbs=array(
	'Faq Cats'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>Yii::t('FaqModule.faq','Manage Cat'), 'url'=>array('index')),
);
?>

<h1><?php echo Yii::t('FaqModule.faq','Create Cat'); ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>