<?php
/* @var $this DefaultController */

$this->breadcrumbs=array(
	$this->module->id,
);
$this->menu = require dirname(__FILE__).'/../commonMenu.php';
?>

<h1>Статические страницы</h1>
<?php $this->widget('bootstrap.widgets.TbGridView', array(
    'id'=>'test-grid',
    'type'=>'striped bordered condensed',
    'dataProvider'=>$data,
    'template'=>"{items}\n{pager}",
    'columns'=>array(
        array('name'=>'id', 'header'=>'#'),
        array(
            'name'=>'filePath', 
            'header'=>'Файл',
            'value'=>"Yii::app()->urlManager->createUrl('site/page',array('view'=>str_replace('.php','.html',basename(\$data['filePath']))))",
            ),
        array(
            'class'=>'bootstrap.widgets.TbButtonColumn',
            'template'=>'{view}{update}{delete}',
             'viewButtonUrl'=>"Yii::app()->urlManager->createUrl('site/page',array('view'=>str_replace('.php','.html',basename(\$data['filePath']))))",
             'deleteButtonUrl'=>'"/pages/default/delete/file/".str_replace("/","*",$data["filePath"])',
             'updateButtonUrl'=>'"/pages/default/update/file/".str_replace("/","*",$data["filePath"])',
        ),
    ),
)); 



?>