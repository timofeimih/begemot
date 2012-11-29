<?php
$this->breadcrumbs=array(
	'Cat Categories'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu = require dirname(__FILE__).'/../catItem/commonMenu.php';
?>

<h1>Update CatCategory <?php echo $model->id; ?></h1>

<?php 

echo $this->renderPartial('_form', array('model'=>$model)); ?>

<?php  $this->renderPartial('messageWidget');?>