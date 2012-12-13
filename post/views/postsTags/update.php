<?php
$this->breadcrumbs=array(
	'Posts Tags'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'Публикации', 'url'=>array('posts/admin')),
	array('label'=>'List PostsTags', 'url'=>array('index')),
	array('label'=>'Create PostsTags', 'url'=>array('create')),
	array('label'=>'View PostsTags', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage PostsTags', 'url'=>array('admin')),
);
?>

<h1>Update PostsTags <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>