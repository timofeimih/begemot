<?php
$this->breadcrumbs=array(
	'Seo Words'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List SeoWord','url'=>array('index')),
	array('label'=>'Create SeoWord','url'=>array('create')),
	array('label'=>'View SeoWord','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage SeoWord','url'=>array('admin')),
);
?>

<h1>Update SeoWord <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>