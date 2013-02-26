<?php
$this->breadcrumbs=array(
	'Seo Word Groups'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List SeoWordGroup','url'=>array('index')),
	array('label'=>'Manage SeoWordGroup','url'=>array('admin')),
);
?>

<h1>Create SeoWordGroup</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>