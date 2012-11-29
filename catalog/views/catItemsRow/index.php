<?php
/* @var $this CatItemsRowController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Cat Items Rows',
);

$this->menu=array(
	array('label'=>'Create CatItemsRow', 'url'=>array('create')),
	array('label'=>'Manage CatItemsRow', 'url'=>array('admin')),
);
?>

<h1>Cat Items Rows</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
