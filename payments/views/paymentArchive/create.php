<?php
/* @var $this PaymentArchiveController */
/* @var $model PaymentArchive */

$this->breadcrumbs=array(
	'Payment Archives'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List PaymentArchive', 'url'=>array('index')),
	array('label'=>'Manage PaymentArchive', 'url'=>array('admin')),
);
?>

<h1>Create PaymentArchive</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>