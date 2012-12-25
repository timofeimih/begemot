<?php
$this->breadcrumbs=array(
	'Posts'=>array('index'),
	'Create',
);

require '_postsMenu.php';
?>

<h1>Create Posts</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>