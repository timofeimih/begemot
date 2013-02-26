<?php
$this->breadcrumbs=array(
	'Seo Word Groups'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List SeoWordGroup','url'=>array('index')),
	array('label'=>'Create SeoWordGroup','url'=>array('create')),
	array('label'=>'Update SeoWordGroup','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete SeoWordGroup','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage SeoWordGroup','url'=>array('admin')),
);
?>

<h1>View SeoWordGroup #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'rgt',
		'level',
		'lft',
	),
)); ?>
