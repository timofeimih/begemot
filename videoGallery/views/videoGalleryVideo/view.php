<?php

$this->breadcrumbs = array(
	$model->label(2) => array('index'),
	GxHtml::valueEx($model),
);

$this->menu = require(dirname(__FILE__).'/../commonMenu.php');
?>

<h1><?php echo 'View' . ' ' . GxHtml::encode($model->label()) . ' ' . GxHtml::encode(GxHtml::valueEx($model)); ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data' => $model,
	'attributes' => array(
'id',
'title',
'text',
'url',
array(
			'name' => 'gallery',
			'type' => 'raw',
			'value' => $model->gallery !== null ? GxHtml::link(GxHtml::encode(GxHtml::valueEx($model->gallery)), array('videoGallery/view', 'id' => GxActiveRecord::extractPkValue($model->gallery, true))) : null,
			),
	),
)); ?>

