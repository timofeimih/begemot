<?php
/* @var $this CatItemController */
/* @var $model CatItem */
Yii::app()->clientScript->registerCssFile(
    Yii::app()->assetManager->publish(Yii::app()->getModule('catalog')->basePath . '/assets/css/styles.css')
);

$this->breadcrumbs=array(
	'Cat Items'=>array('index'),
	'Manage',
);

$menu = require dirname(__FILE__).'/commonMenu.php';

$this->menu = $menu;


?>

<h1>Все позиции каталога</h1>


<?php
 Yii::import('begemot.extensions.grid.EImageColumn');

 $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'test-grid',
	'dataProvider'=>$dataProvider->search(),
	'filter'=>$dataProvider,
    'type'=>'striped bordered condensed',
	'columns'=>array(
                array(
                    'class' => 'EImageColumn',
                    'htmlOptions'=>array('width'=>120),
                    // see below.
                    'imagePathExpression' => '$data->getItemMainPicture()',
                    // Text used when cell is empty.
                    // Optional.
                    'emptyText' => '—',
                    // HTML options for image tag. Optional.
                    'imageOptions' => array(
                        'alt' => 'no',
                        'width' => 120,
                        'height' => 120,
                    ),
                ),            
		'id',
        array(
            'header' => 'Парсится',
            'type'=>'raw',
            'value'=>'$data->combinedWithParser()',
        ),
		'name',    

        array(
            'header' => 'Переключатель публикации',
            'type'=>'raw',
            'value'=>'$data->isPublished()',
        ),
        array(
            'header' => 'Top',
            'type'=>'raw',
            'value'=>'$data->isTop()',
        ),

		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
            'viewButtonUrl'=>'Yii::app()->urlManager->createUrl(\'catalog/site/itemView\',array(\'title\'=>\'tmp_name\',\'catId\'=>$data->catId,\'itemName\'=>$data->name_t,\'item\'=>$data->id,))',
            'viewButtonOptions'=>array('target'=>'_blank')

		),
	),
));



?>

<script>
    $(function(){
        $(document).on("click", ".togglePublished", function(){
            var button = $(this);
            $.get('/catalog/catItem/togglePublished/id/' + $(this).attr('data-id'), function(data){
                button.before("<span class='toDelete'>Сохранено<br/></span>");
                setTimeout(function() { button.parent().find(".toDelete").remove() }, 500);
                
            })
        })

        $(document).on("click", ".toggleTop", function(){
            var button = $(this);
            $.get('/catalog/catItem/toggleTop/id/' + $(this).attr('data-id'), function(data){
                button.before("<span class='toDelete'>Сохранено<br/></span>");
                setTimeout(function() { button.parent().find(".toDelete").remove() }, 500);
                
            })
        })
    })
</script>

