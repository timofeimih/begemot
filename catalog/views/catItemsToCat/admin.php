<?php
/* @var $this CatItemController */
/* @var $model CatItem */

$this->breadcrumbs=array(
	'Cat Items'=>array('index'),
	'Manage',
);

$this->menu = require dirname(__FILE__).'/../catItem/commonMenu.php';

?>

<h1>Раздел "<?php echo $category->name;?>"</h1>


<?php
 Yii::import('begemot.extensions.grid.EImageColumn');
 
 $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'test-grid',
	'dataProvider'=>$dataProvider,//$model->search($id),
	'filter'=>$model,
        'type'=>'striped bordered condensed',
	'columns'=>array(
            
                array(
                    'class' => 'EImageColumn',
                    'htmlOptions'=>array('width'=>120),
                    // see below.
                    'imagePathExpression' => '$data->item->getItemMainPicture("small")',
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
                array(
                      'name'=>'name',
                      'value'=>'$data->item->name',
                    
                  ),
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
                        'updateButtonUrl'=>'Yii::app()->controller->createUrl("catItem/update",array("id"=>$data->itemId))',
                       // 'updateButtonUrl'=>'"catItem/update/id/".$data->itemId',
		),
                array(
                        'class' => 'begemot.extensions.order.gridView.CBOrderColumn',
                        'header'=>'порядок',
                ),
	),
));



?>
