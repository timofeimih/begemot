<div class="form">

<?php $form = $this->beginWidget('UActiveForm', array(
	'id' => 'tasks-form',
	'enableAjaxValidation' => true,
));
?>

	<p class="note">
		Fields with <span class="required">*</span> are required.
	</p>

	<?php echo $form->errorSummary($model); ?>

		<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model, 'title', array('maxlength' => 255)); ?>
		<?php echo $form->error($model,'title'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'title_t'); ?>
		<?php echo $form->textField($model, 'title_t', array('maxlength' => 255)); ?>
		<?php echo $form->error($model,'title_t'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'text'); ?>
		<?php echo $form->textArea($model, 'text'); ?>
		<?php echo $form->error($model,'text'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'update_time'); ?>
		<?php echo $form->textField($model, 'update_time', array('maxlength' => 45)); ?>
		<?php echo $form->error($model,'update_time'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'create_time'); ?>
		<?php echo $form->textField($model, 'create_time'); ?>
		<?php echo $form->error($model,'create_time'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'likes'); ?>
		<?php echo $form->textField($model, 'likes'); ?>
		<?php echo $form->error($model,'likes'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'user_id'); ?>
		<?php echo $form->textField($model, 'user_id'); ?>
		<?php echo $form->error($model,'user_id'); ?>
		</div><!-- row -->


<?php
echo CHtml::submitButton('Save');
$this->endWidget();
?>
</div><!-- form -->