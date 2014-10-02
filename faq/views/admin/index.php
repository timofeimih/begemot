<?php
$this->breadcrumbs=array(
	Yii::t('FaqModule.faq','Faq') =>array('/faq/admin'),
);

require Yii::getPathOfAlias('webroot').'/protected/modules/faq/views/admin/_postsMenu.php';

?>
<h1><? echo Yii::t('FaqModule.faq','Manage Faq'); ?></h1>
<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'id'=>'faq-grid',
	'dataProvider'=>$model->search($cid),
	'filter'=>$model,
	'columns'=>array(
      'name',
		'question',
		'email',
		'create_at',
		array(
			'name'=>'answered',
			'value'=>'Faq::itemAlias("Answered",$data->answered)',
			'filter' => Faq::itemAlias("Answered"),
		),		
      array(
			'name'=>'published',
			'value'=>'Faq::itemAlias("Published",$data->published)',
			'filter' => Faq::itemAlias("Published"),
		),
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>
