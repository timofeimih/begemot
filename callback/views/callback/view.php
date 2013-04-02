<?php
$this->breadcrumbs=array(
	'Callbacks'=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>'List Callback','url'=>array('index')),
	array('label'=>'Manage Callback','url'=>array('admin')),
);
?>

<h1>View Callback #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'date',
		'group',
		'title',
		'text',
	),
)); ?>
