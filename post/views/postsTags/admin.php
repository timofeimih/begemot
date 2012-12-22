<?php

require Yii::getPathOfAlias('webroot').'/protected/modules/post/views/default/_postsMenu.php';

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('posts-tags-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Управление разделами статей</h1>

<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'id'=>'posts-tags-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
        'type'=>'striped bordered condensed',
	'columns'=>array(
		'id',
		'tag_name',
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>
