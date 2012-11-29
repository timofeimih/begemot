<?php
$this->breadcrumbs=array(
	'Cat Categories'=>array('index'),
	$model->name,
);

$this->menu = require dirname(__FILE__).'/../catItem/commonMenu.php';
?>

<h1>View CatCategory #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'pid',
		'name',
		'text',
		'order',
		'dateCreate',
		'dateUpdate',
		'status',

	),
)); ?>
