<?php
/* @var $this CatItemController */
/* @var $model CatItem */

$this->breadcrumbs=array(
	'Cat Items'=>array('index'),
	'Create',
);

$this->menu = require dirname(__FILE__).'/commonMenu.php';
?>

<h1>Создать элемент каталога</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>