<?php
/* @var $this FaqCatsController */
/* @var $model FaqCats */

$this->breadcrumbs=array(
	'Faq Cats'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>Yii::t('FaqModule.faq','Create Cat'), 'url'=>array('create')),
	array('label'=>Yii::t('FaqModule.faq','Manage Faq'), 'url'=>array('admin/')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#faq-cats-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1><? echo Yii::t('FaqModule.faq','Manage Cat'); ?></h1>

<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'id'=>'faq-cats-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'name',
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>
