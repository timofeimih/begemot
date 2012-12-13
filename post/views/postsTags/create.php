<?php
$this->breadcrumbs=array(
	'Posts Tags'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'Публикации', 'url'=>array('posts/admin')),
	array('label'=>'List PostsTags', 'url'=>array('index')),
	array('label'=>'Manage PostsTags', 'url'=>array('admin')),
);
?>

<h1>Create PostsTags</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>