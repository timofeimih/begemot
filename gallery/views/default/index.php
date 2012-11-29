<?php
$this->breadcrumbs=array(
	'Galleries',
);

$this->menu=array(
	array('label'=>'Create Gallery','url'=>array('create')),
	array('label'=>'Manage Gallery','url'=>array('admin')),
);
?>

<h1>Galleries</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
