<?php
require Yii::getPathOfAlias('webroot').'/protected/modules/post/views/default/_postsMenu.php';
?>

<h1>Update PostsTags <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>