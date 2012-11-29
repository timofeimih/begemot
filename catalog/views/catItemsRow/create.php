<?php
/* @var $this CatItemsRowController */
/* @var $model CatItemsRow */

$this->breadcrumbs=array(
	'Cat Items Rows'=>array('index'),
	'Create',
);

$this->menu = require dirname(__FILE__).'/../catItem/commonMenu.php';

?>

<h1>Создать дополнительное поле</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>