<?php
$this->breadcrumbs=array(
	'Cat Categories',
);

$this->menu=array(
	array('label'=>'Create CatCategory', 'url'=>array('create')),
	array('label'=>'Manage CatCategory', 'url'=>array('admin')),
);
?>

<h1>Cat Categories</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
