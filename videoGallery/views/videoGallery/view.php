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
'name',
'name_t',
'text',
'order',
'seo_title',
	),
)); ?>

<h2><?php echo GxHtml::encode($model->getRelationLabel('videoGalleryVideos')); ?></h2>
<?php
	echo GxHtml::openTag('ul');
	foreach($model->videoGalleryVideos as $relatedModel) {
		echo GxHtml::openTag('li');
		echo GxHtml::link(GxHtml::encode(GxHtml::valueEx($relatedModel)), array('videoGalleryVideo/view', 'id' => GxActiveRecord::extractPkValue($relatedModel, true)));
		echo GxHtml::closeTag('li');
	}
	echo GxHtml::closeTag('ul');
?>