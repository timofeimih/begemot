<?php
/* @var $this PaymentArchiveController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Payment Archives',
);

$this->menu=array(
	array('label'=>'Create PaymentArchive', 'url'=>array('create')),
	array('label'=>'Manage PaymentArchive', 'url'=>array('admin')),
);
?>

<h1>Payment Archives</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
