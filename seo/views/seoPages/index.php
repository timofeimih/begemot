<?php
$this->breadcrumbs=array(
	'Seo Pages',
);

$this->menu=array(
	array('label'=>'Create SeoPages','url'=>array('create')),
	array('label'=>'Manage SeoPages','url'=>array('admin')),
);
?>

<h1>Seo Pages</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
