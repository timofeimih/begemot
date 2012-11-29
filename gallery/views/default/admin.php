<?php
$this->breadcrumbs=array(
	'Galleries'=>array('index'),
	'Manage',
);
$this->menu = require dirname(__FILE__).'/commonMenu.php';

Yii::app()->clientScript->registerScript('search', "

$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('gallery-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Фотогаллерея. Управление.</h1>



<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'gallery-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(

		'name',

		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
                array(
                        'class' => 'begemot.extensions.order.gridView.CBOrderColumn',
                        "header"=>"порядок",
                ),            
	),
)); ?>
