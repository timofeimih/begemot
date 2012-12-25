<?php
$this->breadcrumbs=array(
	'Posts Tags',
);

$this->menu=array(
	array('label'=>'Публикации', 'url'=>array('posts/admin')),
	array('label'=>'Create PostsTags', 'url'=>array('create')),
	array('label'=>'Manage PostsTags', 'url'=>array('admin')),
);
?>

<h1>Posts Tags</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
