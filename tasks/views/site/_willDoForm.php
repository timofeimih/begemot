
<?php $form = $this->beginWidget('UActiveForm', array(
	'id' => 'tasks-to-user-form',
	'enableAjaxValidation' => true,

	'clientOptions'=>array(
		'validateOnSubmit'=>true,
		'afterValidate' => 'js: validateAjaxForm'
		//'afterValidate' => 'js: function(form, data, hasError) {alert("data")}'
	),
));
?>
	 <?php echo $form->errorSummary($model) ?>
	<div class="hide">
		<?php echo $form->error($model,'text'); ?>
		<?php echo $form->error($model,'price'); ?>
		<?php echo $form->error($model,'task_id'); ?>
	</div>

	<div class='info'></div>
	<div class="success"></div>

	<p>Как будете выполнять задание</p>

	<div class="form-group">
		<?php echo $form->textField($model,'video_link', array('placeholder' => 'Ссылка на видео', 'class' => 'form-control')); ?> 
	</div>
    <p>Скопируйте ссылку видеобращения с Youtube</p>
    <div class="form-group">
    	<?php echo $form->textarea($model,'text', array('placeholder' => 'Ваш комментарий', 'class' => 'form-control', 'rows' => 5)); ?>
    </div>
    <div class="form-group price-input">
    	<?php echo $form->textField($model,'price', array('placeholder' => 'Награда', 'class' => 'form-control')); ?>
        <span>р.</span>
    </div>
    <?php echo $form->hiddenField($model,'task_id', array('value' => $_GET['task_id'])); ?>
    <?php echo CHtml::submitButton('Отправить', array('class' => 'btn btn-border')); ?>

<?php $this->endWidget();?>

