<?php
/* @var $this CatItemsRowController */
/* @var $model CatItemsRow */

$this->breadcrumbs=array(
	'Cat Items Rows'=>array('index'),
	$model->name,
);

$this->menu = require dirname(__FILE__).'/../catItem/commonMenu.php';
?>

<h1>View CatItemsRow #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'name_t',
		'type',
		'data',
	),
)); ?>
