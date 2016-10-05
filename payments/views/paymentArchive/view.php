<?php
/* @var $this PaymentArchiveController */
/* @var $model PaymentArchive */

$this->breadcrumbs=array(
	'Payment Archives'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List PaymentArchive', 'url'=>array('index')),
	array('label'=>'Create PaymentArchive', 'url'=>array('create')),
	array('label'=>'Update PaymentArchive', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete PaymentArchive', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage PaymentArchive', 'url'=>array('admin')),
);
?>

<h1>View PaymentArchive #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'from',
		'to',
		'sum',
		'way',
		'date',
	),
)); ?>
