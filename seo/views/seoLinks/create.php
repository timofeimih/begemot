<?php
$this->breadcrumbs=array(
	'Seo Links'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List SeoLinks','url'=>array('index')),
	array('label'=>'Manage SeoLinks','url'=>array('admin')),
);
?>

<h1>Create SeoLinks</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>