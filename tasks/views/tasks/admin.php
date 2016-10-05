<?php

$this->breadcrumbs = array(
	$model->label(2) => array('index'),
	'Manage',
);

$this->menu = array(
		array('label'=>'List' . ' ' . $model->label(2), 'url'=>array('index')),
		array('label'=>'Create' . ' ' . $model->label(), 'url'=>array('create')),
	);


?>

<h1><?php echo 'Manage' . ' ' . GxHtml::encode($model->label(2)); ?></h1>


<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'callback-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'title',
		'title_t',
		'text',
		'update_time',
		'create_time',
		'likes',
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
            'template'=>'{view}'
		),
	),
)); ?>

