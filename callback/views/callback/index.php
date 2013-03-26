<?php
$this->breadcrumbs=array(
	'Callbacks',
);

$this->menu=array(
    array('label'=>'List Callback','url'=>array('index')),
     array('label'=>'Manage Callback','url'=>array('admin')),
);
?>

<h1>Callbacks</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
