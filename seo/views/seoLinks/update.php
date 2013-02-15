<?php
$this->breadcrumbs=array(
	'Seo Links'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List SeoLinks','url'=>array('index')),
	array('label'=>'Create SeoLinks','url'=>array('create')),
	array('label'=>'View SeoLinks','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage SeoLinks','url'=>array('admin')),
);
?>

<h1>Update SeoLinks <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>