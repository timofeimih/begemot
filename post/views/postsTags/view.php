<?php
require Yii::getPathOfAlias('webroot').'/protected/modules/post/views/default/_postsMenu.php';
?>

<h1>View PostsTags #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'tag_name',
	),
)); ?>
