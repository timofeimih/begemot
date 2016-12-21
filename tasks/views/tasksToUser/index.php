<?php

$this->breadcrumbs = array(
	TasksToUser::label(2),
	'Index',
);

$this->menu = array(
	array('label'=>'Create' . ' ' . TasksToUser::label(), 'url' => array('create')),
	array('label'=>'Manage' . ' ' . TasksToUser::label(2), 'url' => array('admin')),
);
?>

<h1><?php echo GxHtml::encode(TasksToUser::label(2)); ?></h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); 