<?php
$this->breadcrumbs=array(
	'Seo Pages'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List SeoPages','url'=>array('index')),
	array('label'=>'Manage SeoPages','url'=>array('admin')),
);
?>

<h1>Create SeoPages</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>