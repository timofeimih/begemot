<?php
$this->breadcrumbs=array(
	'Cat Categories'=>array('index'),
	'Create',
);

$this->menu = require dirname(__FILE__).'/../catItem/commonMenu.php';
?>

<h1>Create CatCategory</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>