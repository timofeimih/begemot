<div class="popup__block zoom-anim-dialog popup-dialog" style='width: 428px'>
	<h2>Подписка на рассылку</h2>


	<?php $form = $this->beginWidget('UActiveForm', array(
		'id' => 'tasks-subscribe',
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
			<?php echo $form->error($model,'email'); ?>
			<?php echo $form->error($model,'task_id'); ?>
		</div>

		<div class='info'></div>
		<div class="success"></div>

		<div class="form-group">
			<?php echo $form->emailField($model,'email', array('placeholder' => 'E-майл', 'class' => 'form-control')); ?> 
		</div>

	    <?php echo $form->hiddenField($model,'task_id', array('value' => intval($_GET['task_id']))); ?>
	    <?php echo CHtml::submitButton('Отправить', array('class' => 'btn btn-border')); ?>

	<?php $this->endWidget();?>

</div>