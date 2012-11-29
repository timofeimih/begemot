<?php
/* @var $this CatItemController */
/* @var $model CatItem */

$this->breadcrumbs=array(
	'Cat Items'=>array('index'),
	$model->name,
);

$this->menu = require dirname(__FILE__).'/../catItem/commonMenu.php';
?>

<h1>View CatItem #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'name_t',
		'status',
		'data',
	),
)); ?>
