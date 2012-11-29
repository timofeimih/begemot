<?php


$this->menu = require dirname(__FILE__).'/commonMenu.php';
?>

<h1>Редактируем галлерею "<?php echo $model->name; ?>"</h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>