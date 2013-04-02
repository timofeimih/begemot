<?php
$this->breadcrumbs=array(
	'Seo Word Groups'=>array('index'),
	$model->title=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List SeoWordGroup','url'=>array('index')),
	array('label'=>'Create SeoWordGroup','url'=>array('create')),
	array('label'=>'View SeoWordGroup','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage SeoWordGroup','url'=>array('admin')),
);
?>

<h4>Редактируем группу номер <?php echo $model->id; ?></h4>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>