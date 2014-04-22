<?php
/* @var $this DefaultController */

$this->breadcrumbs=array(
	$this->module->id,
);
$this->menu = require dirname(__FILE__).'/../commonMenu.php';
?>

<h1>Статические переменные</h1>
<?php $this->widget('bootstrap.widgets.TbGridView', array(
    'id'=>'test-grid',
    'type'=>'striped bordered condensed',
    'dataProvider'=>$data,
    'template'=>"{items}\n{pager}",
    'columns'=>array(
        array('name'=>'varname', 'header'=>'#'),
        array(
            'name'=>'vardata',
            'header'=>'Данные',

            ),
        array(
            'class'=>'bootstrap.widgets.TbButtonColumn',
            'template'=>'{update}{delete}',
             'deleteButtonUrl'=>'"/vars/default/delete/id/".$data["id"]',
             'updateButtonUrl'=>'"/vars/default/update/id/".$data["id"]',
        ),
    ),
));



?>