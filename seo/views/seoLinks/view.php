<?php
$this->breadcrumbs=array(
	'Seo Links'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List SeoLinks','url'=>array('index')),
	array('label'=>'Create SeoLinks','url'=>array('create')),
	array('label'=>'Update SeoLinks','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete SeoLinks','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage SeoLinks','url'=>array('admin')),
);
?>

<h1>View SeoLinks #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'url',
		'href',
		'anchor',
		'type',
	),
)); ?>
