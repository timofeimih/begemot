<?php
/* @var $this PaymentArchiveController */
/* @var $model PaymentArchive */

$this->breadcrumbs=array(
	'Payment Archives'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List PaymentArchive', 'url'=>array('index')),
	array('label'=>'Create PaymentArchive', 'url'=>array('create')),
	array('label'=>'View PaymentArchive', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage PaymentArchive', 'url'=>array('admin')),
);
?>

<h1>Update PaymentArchive <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>