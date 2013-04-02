<?php

$this->breadcrumbs = array(
	$model->label(2) => array('index'),
	'Manage',
);

$this->menu = require(dirname(__FILE__).'/../commonMenu.php');

?>

<h1><?php echo 'Manage' . ' ' . GxHtml::encode($model->label(2)); ?></h1>




<?php $this->widget('bootstrap.widgets.TbExtendedGridView', array(
	'id' => 'video-gallery-grid',
	'dataProvider' => $model->search(),
	'filter' => $model,
	'columns' => array(
		'id',
		'name',
		array(
			'class' => 'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>