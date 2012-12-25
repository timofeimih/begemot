<?php
require Yii::getPathOfAlias('webroot').'/protected/modules/post/views/default/_postsMenu.php';
?>

<h1>Create PostsTags</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>