<?php

$this->breadcrumbs = array(
	Tasks::label(2),
	'Index',
);

$this->menu = array(
	array('label'=>'Create' . ' ' . Tasks::label(), 'url' => array('create')),
	array('label'=>'Manage' . ' ' . Tasks::label(2), 'url' => array('admin')),
);
?>

<h1><?php echo GxHtml::encode(Tasks::label(2)); ?></h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); 