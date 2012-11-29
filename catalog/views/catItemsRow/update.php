<?php
/* @var $this CatItemsRowController */
/* @var $model CatItemsRow */

$this->breadcrumbs=array(
	'Cat Items Rows'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List CatItemsRow', 'url'=>array('index')),
	array('label'=>'Create CatItemsRow', 'url'=>array('create')),
	array('label'=>'View CatItemsRow', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage CatItemsRow', 'url'=>array('admin')),
);
?>

<h1>Update CatItemsRow <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>