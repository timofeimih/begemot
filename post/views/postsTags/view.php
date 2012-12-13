<?php
$this->breadcrumbs=array(
	'Posts Tags'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'Публикации', 'url'=>array('posts/admin')),
	array('label'=>'List PostsTags', 'url'=>array('index')),
	array('label'=>'Create PostsTags', 'url'=>array('create')),
	array('label'=>'Update PostsTags', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete PostsTags', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage PostsTags', 'url'=>array('admin')),
);
?>

<h1>View PostsTags #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'tag_name',
	),
)); ?>
