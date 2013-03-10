<div class="wide form">

<?php $form = $this->beginWidget('GxActiveForm', array(
	'action' => Yii::app()->createUrl($this->route),
	'method' => 'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model, 'id'); ?>
		<?php echo $form->textField($model, 'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'name'); ?>
		<?php echo $form->textField($model, 'name', array('maxlength' => 255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'name_t'); ?>
		<?php echo $form->textField($model, 'name_t', array('maxlength' => 255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'text'); ?>
		<?php echo $form->textArea($model, 'text'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'order'); ?>
		<?php echo $form->textField($model, 'order'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'seo_title'); ?>
		<?php echo $form->textField($model, 'seo_title', array('maxlength' => 255)); ?>
	</div>

	<div class="row buttons">
		<?php echo GxHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
