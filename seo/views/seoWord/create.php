<?php
$this->breadcrumbs=array(
	'Seo Words'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List SeoWord','url'=>array('index')),
	array('label'=>'Manage SeoWord','url'=>array('admin')),
);
?>

<h1>Create SeoWord</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>