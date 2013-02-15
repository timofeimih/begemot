<?php
$this->breadcrumbs=array(
	'Seo Links',
);

$this->menu=array(
	array('label'=>'Create SeoLinks','url'=>array('create')),
	array('label'=>'Manage SeoLinks','url'=>array('admin')),
);
?>

<h1>Seo Links</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
